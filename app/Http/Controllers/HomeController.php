<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\MenuRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
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

    public function index(Request $request)
    {
            // 1️⃣ Get table number from QR scan
        $tableNumber = $request->query('table'); // from QR
        if ($tableNumber) {
            session(['table_number' => $tableNumber, 'table_scanned_at' => now()]);
        }

        // 2️⃣ Use session if no query parameter
        $tableNumber = $tableNumber ?? session('table_number');

        // 3️⃣ Load homepage data
        $categories = $this->categoryRepository->getAllCategories();
        $menus = $this->menuRepository->getAllMenus();
        $popularMenus = $this->menuRepository->getPopularMenus();
        $promoMenus = $this->menuRepository->getPromoMenus();

        // 4️⃣ Return view with all data
        return view('pages.home', compact(
            'categories',
            'menus',
            'popularMenus',
            'promoMenus',
            'tableNumber'
        ));  
    }

    public function promoMenus()
    {
        $promoMenus = $this->menuRepository->getPromoMenus();

        return view('pages.menu.promo', compact('promoMenus'));    
    }

    public function popularMenus()
    {
        $popularMenus = $this->menuRepository->getPopularMenus();

        return view('pages.menu.popular', compact('popularMenus'));    
    }

    public function allMenus(Request $request)
    {
        $search = $request->input('search');
        $allMenus = $this->menuRepository->getAllMenus($search);

        return view('pages.menu.all', compact('allMenus'));    
    }

}
