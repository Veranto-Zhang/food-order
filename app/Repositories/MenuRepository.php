<?php 

namespace App\Repositories;

use App\Interfaces\MenuRepositoryInterface;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Builder;

class MenuRepository implements MenuRepositoryInterface{

    public function getAllMenus($search = null, $category = null){
        $query = Menu::query();

        if($search){
            $query->where('name', 'like', '%' . $search . '%');
        }

        if($category){
            $query->whereHas('category', function (Builder $query) use ($category){
                $query->where('slug' , $category);
            });
        }

        return $query->paginate(20);
    }

    public function getPopularMenus($limit = 6){
        return Menu::orderByDesc('sold_count')
        ->orderByDesc('created_at')
        ->take($limit)
        ->get();
    }

    public function getPromoMenus($limit = null){
        $query = Menu::where('is_promo', true);

        if ($limit) {
            $query->take($limit);
        }

        return $query->get();
    }

    public function getMenuByCategorySlug($slug){
        return Menu::whereHas('category', function (Builder $query) use ($slug){
            $query->where('slug', $slug);
        })->get();
    }

    public function getMenuBySlug($slug){
        // return Menu::where('slug', $slug)->first();
        return Menu::with([
            'menuOptionGroups.optionGroup.optionValues'
        ])->where('slug', $slug)->firstOrFail();
    }


}


?>