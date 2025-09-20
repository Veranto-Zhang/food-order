<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderShowRequest;
use App\Http\Requests\SaveOrderRequest;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\MenuRepositoryInterface;
use App\Interfaces\OrderItemRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Menu;
use App\Models\OptionValue;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemOption;
use App\Models\PromoCode;
use App\Repositories\OrderItemRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    private CategoryRepositoryInterface $categoryRepository;
    private MenuRepositoryInterface $menuRepository;
    private OrderItemRepositoryInterface $orderItemRepository;
    private OrderRepositoryInterface $orderRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        MenuRepositoryInterface $menuRepository,
        OrderItemRepositoryInterface $orderItemRepository,
        OrderRepositoryInterface $orderRepository,
    ){
        $this->categoryRepository = $categoryRepository;
        $this->menuRepository = $menuRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->orderRepository = $orderRepository;
    }

    // add item to cart
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'menu_id'  => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $menu = Menu::findOrFail($validated['menu_id']);

        // Collect option IDs grouped by option_group
        $options = collect($request->all())
            ->filter(fn($value, $key) => str_starts_with($key, 'option_group_'))
            ->map(function ($value, $key) {
                $groupId = (int) str_replace('option_group_', '', $key);
                return [
                    'group_id' => $groupId,
                    'values'   => (array) $value, // ensure always array
                ];
            })
            ->values();

        // Flatten option IDs
        $optionIds = $options->flatMap(fn($opt) => $opt['values'])->all();

        // Fetch options with group relationship
        $optionValues = collect();
        if (!empty($optionIds)) {
            $optionValues = OptionValue::with('optionGroup')
                ->whereIn('id', $optionIds)
                ->get();
        }

        $extraTotal = $optionValues->sum('extra_price');

        // Format options with group name
        $formattedOptions = $optionValues->map(fn($opt) => [
            'id'      => $opt->id,
            'group'   => $opt->optionGroup->name,
            'name'    => $opt->name,
            'extra'   => $opt->extra_price,
        ])->toArray();

        $basePrice = $menu->is_promo ? $menu->price_after_discount : $menu->price;

        $itemPrice = $basePrice + $extraTotal;

        $cartItem = [
            'menu_id'   => $menu->id,
            'menu_name'   => $menu->name,
            'quantity'  => $validated['quantity'],
            'itemPrice' => $itemPrice,
            'options'   => $formattedOptions,
            'image'   => $menu->thumbnail,
            'subtotal'  => $itemPrice * $validated['quantity'],
        ];

        $cart = session()->get('cart', []);

        // Generate a unique key based on menu_id + options (so same item + options merge)
        $key = $menu->id . '-' . md5(json_encode($formattedOptions));

        if (isset($cart[$key])) {
            // Already in cart → update
            $cart[$key]['quantity'] += $validated['quantity'];
            $cart[$key]['subtotal'] = $cart[$key]['quantity'] * $cart[$key]['itemPrice'];
        } else {
            $cart[$key] = $cartItem;
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Item added to cart!');
    }

    public function checkout(){
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Your cart is empty.');
        }

        $subtotal = collect($cart)->sum(fn($item) => $item['itemPrice'] * $item['quantity']);
        $tax = $subtotal * 0.11;
        $grandTotal = $subtotal + $tax;

        return view('pages.order.checkout', compact('cart', 'subtotal', 'tax', 'grandTotal'));
    }

    public function saveOrder(SaveOrderRequest $request){

        $cart = session('cart', []);
        $checkoutData = session('checkout_data');
        $code = $this->generateTransactionCode();
        $payment_method = $request->payment_method;
        // $tableNumber = session('table_number');
        $tableNumber = "a12";
        // $name = $request->name;
        // $phone = $request->phone_number;
        // $payment_status = $method === 'pay_at_cashier' ? 'unpaid' : 'pending';
        // $order_status = 'pending';
        

        if (empty($cart)) {
            return redirect()->route('show.cart')->with('error', 'Your cart is empty');
        }

        $subtotal = collect($cart)->sum(fn($item) => $item['itemPrice'] * $item['quantity']);
        $tax = round($subtotal * 0.11);
        $grandTotal = $subtotal + $tax;

        // Buat order 
        $order = Order::create([
            'code'            => $code,
            // 'name'            => $name,
            // 'phone_number'    => $phone,
            'table_no'        => $tableNumber,
            'payment_method'  => $payment_method,
            'payment_status'  => $payment_method === 'pay_at_cashier' ? 'unpaid' : 'pending',
            'order_status'    => 'pending',
            'transaction_date'=> now()->toDateString(),
            'tax'             => $tax,
            'total_amount'    => $grandTotal,
        ]);

        // Buat order items
        foreach ($cart as $item) {
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'menu_id'  => $item['menu_id'],
                'quantity' => $item['quantity'],
                'price'    => $item['itemPrice'],
                'subtotal' => $item['subtotal'],
            ]);

            // Update sold_count via relasi
            $orderItem->menu()->increment('sold_count', $item['quantity']);

            // Simpan opsi per item (kalau ada)
            if (!empty($item['options'])) {
                foreach ($item['options'] as $opt) {
                    OrderItemOption::create([
                        'order_item_id'   => $orderItem->id,
                        'option_value_id' => $opt['id'],
                        'extra_price'     => $opt['extra'],
                    ]);
                }
            }
        }

        // clear session
        session()->forget(['cart']);


        if ($payment_method === 'online_payment') {
            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = config('midtrans.isProduction');
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = config('midtrans.is3ds');

            $params = [
                'transaction_details' => [
                    'order_id' => $order->code,
                    'gross_amount' => $order->total_amount,
                ],
            ];

            $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;
            return redirect($paymentUrl);
        } 

        return redirect()->route('checkout.success', ['order_id' => $order->code])
             ->with('success', 'Order berhasil dibuat.');     
        
    }

    public function success(Request $request){
        $orderCode = $request->query('order_id'); 
        $order = $this->orderRepository->getOrderByCode($orderCode);

        if(!$order){
            return redirect()->route('home');
        }

        return view('pages.order.success', compact('order'));
    }

    private function generateTransactionCode()
    {
        return DB::transaction(function () {
            $year = now()->format('Y');

            // Lock table biar gak ada yang nyelip
            $lastOrder = Order::whereYear('created_at', $year)
                ->lockForUpdate()
                ->orderBy('id', 'desc')
                ->first();

            if ($lastOrder && preg_match("/Ord-{$year}(\d+)/", $lastOrder->code, $matches)) {
                $lastNumber = (int)$matches[1];
            } else {
                $lastNumber = 0;
            }

            // Increment
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

            return "Ord-{$year}{$newNumber}";
        });
    }

    public function check(){
        return view('pages.order.check-order');
    }
    
    public function show(OrderShowRequest $request){
        $order = $this->orderRepository->getOrderByCode($request->code);

        if(!$order){
            return redirect()->back()->with('error', 'Order Tidak Ditemukan');
        }

        return view('pages.order.detail', compact('order'));
    }

    public function downloadReceipt($id)
    {
        $order = Order::with(['orderItems.menu', 'orderItems.orderItemOptions.optionValue.optionGroup'])
                    ->findOrFail($id);

        $pdf = Pdf::loadView('pages.order.receipt', compact('order'));

        return $pdf->download('receipt-'.$order->code.'.pdf');
    }

}
