<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\MenuRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepository;
    private MenuRepositoryInterface $menuRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        MenuRepositoryInterface $menuRepository
    ){
        $this->categoryRepository = $categoryRepository;
        $this->menuRepository = $menuRepository;
    }

    public function show($slug){
        $category = $this->categoryRepository->getCategoryBySlug($slug);
        $menus = $this->menuRepository->getMenuByCategorySlug($slug);
        $categories = Category::all();

        return view('pages.category.show', compact('menus', 'category', 'categories'));
    }

}
