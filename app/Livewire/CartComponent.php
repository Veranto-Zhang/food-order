<?php

namespace App\Livewire;

use App\Models\PromoCode;
use Livewire\Component;

class CartComponent extends Component
{
    public $cart = [];
    public $taxRate = 0.11; 
    public $promo_code = '';
    public $promoError = '';
    public $promoSuccess = '';
    public $discount = 0;

    protected $listeners = ['cartUpdated' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cart = session()->get('cart', []);
    }

    public function increaseQty($key)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$key])) {
            $cart[$key]['quantity']++;
            $cart[$key]['subtotal'] = $cart[$key]['quantity'] * $cart[$key]['itemPrice'];
            session()->put('cart', $cart);
            $this->loadCart();
        }
    }

    public function decreaseQty($key)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$key])) {
            $cart[$key]['quantity']--;
            if ($cart[$key]['quantity'] <= 0) {
                unset($cart[$key]);
            } else {
                $cart[$key]['subtotal'] = $cart[$key]['quantity'] * $cart[$key]['itemPrice'];
            }
            session()->put('cart', $cart);
            $this->loadCart();
        }
    }

    public function removeItem($key)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
            $this->loadCart();
        }
    }

    public function clearCart()
    {
        session()->forget('cart');
        $this->loadCart();
    }

    public function applyPromo()
    {
        $this->promoError = '';
        $this->promoSuccess = '';
        $this->discount = 0;

        // Check subtotal requirement
        if ($this->subtotal < 100000) {
            $this->promoError = "Promo code can only be applied if you spend at least Rp 100.000";
            return;
        }

        $code = strtoupper(trim($this->promo_code));
        $promo = PromoCode::where('code', $code)->first();

        if (! $promo) {
            $this->promoError = 'Invalid promo code.';
            return;
        }

        if ($promo->expires_at && $promo->expires_at->isPast()) {
            $this->promoError = 'This promo code has expired.';
            return;
        }

        $grandTotal = $this->subtotal + $this->tax;

        if ($promo->discount_type === 'fixed') {
            $this->discount = min($promo->discount_value, $grandTotal);
        } else {
            $this->discount = $grandTotal * ($promo->discount_value / 100);
        }

        $this->promoSuccess = "Promo code \"{$code}\" applied successfully!";
    }

    public function getSubtotalProperty()
    {
        return collect($this->cart)->sum('subtotal');
    }

    public function getTaxProperty()
    {
        return $this->subtotal * $this->taxRate;
    }

    public function getGrandTotalProperty()
    {
        return max(0, $this->subtotal + $this->tax - $this->discount);
    }

    public function render()
    {
        return view('livewire.cart-component');
    }
}
