<?php 

namespace App\Repositories;

use App\Interfaces\OrderItemRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface{

    public function updateOrderStatus($code, $payment_status){
        $order = Order::where('code', $code)->first();
        $order->status = $payment_status;
        $order->save();

        return $order;
    }

    public function getOrderByCode($code){
        return Order::with([
            'orderItems.menu',
            'orderItems.orderItemOptions.optionValue.optionGroup',
        ])->where('code', $code)->first();
    }

    public function getOrderByCodeName($code,$name){
        return Order::with([
            'orderItems.menu',
            'orderItems.orderItemOptions.optionValue.optionGroup',
        ])->where('code', $code)->where('name', $name)->first();
    }

    private function generateTransactionCode(){
        $year = now()->format('Y');

        // Get the last transaction of this year
        $lastOrder = Order::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastOrder && preg_match("/pltrx{$year}(\d+)/", $lastOrder->transaction_code, $matches)) {
            $lastNumber = (int)$matches[1];
        } else {
            $lastNumber = 0;
        }

        // Increment
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        return "pltrx{$year}{$newNumber}";
    }

    


}


?>