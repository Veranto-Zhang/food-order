<?php 

namespace App\Repositories;

use App\Interfaces\OrderItemRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use App\Models\OrderItem;

class OrderItemRepository implements OrderItemRepositoryInterface{

    public function createOrderItem($data){
        return OrderItem::create($data);
    }

    public function deleteOrderItem($id){
        return OrderItem::destroy($id);
    }



}


?>