<?php 

namespace App\Interfaces;

interface OrderRepositoryInterface {

    public function updateOrderStatus($code, $payment_status);

    public function getOrderByCode($code);

    public function getOrderByCodeName($code,$name);

    // public function saveOrder($data);
    

}


?>