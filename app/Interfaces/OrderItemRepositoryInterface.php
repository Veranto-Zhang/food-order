<?php 

namespace App\Interfaces;

interface OrderItemRepositoryInterface{

    public function createOrderItem($data);

    public function deleteOrderItem($id);


}



?>