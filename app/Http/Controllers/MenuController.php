<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\MenuRepositoryInterface;
use Illuminate\Http\Request;

class MenuController extends Controller
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
        $menu = $this->menuRepository->getMenuBySlug($slug);

        return view('pages.menu.show', compact('menu'));

    }


}
