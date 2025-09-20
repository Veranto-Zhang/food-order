<?php 

namespace App\Interfaces;

interface MenuRepositoryInterface{

    public function getAllMenus($search = null, $category = null);

    public function getPopularMenus($limit = 6);

    public function getPromoMenus($limit = null);

    public function getMenuByCategorySlug($slug);
    
    public function getMenuBySlug($slug);

}


?>