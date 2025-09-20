<?php 

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface{

    public function getAllCategories(){
        return Category::with('menus')->get();
    }

    public function getCategoryBySlug($slug){
        return Category::where('slug', $slug)->with('menus')->first();
    }

}



?>