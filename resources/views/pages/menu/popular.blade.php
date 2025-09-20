@extends('layouts.app')

@section('content')

<div id="Background" class="absolute top-0 w-full h-[230px] rounded-b-[75px] bg-[linear-gradient(180deg,#FFF3E0_0%,#FFE0C7_100%)]"></div>
<div id="TopNav" class="relative flex items-center justify-between px-4 my-[30px]">
    <a href="{{ route('home') }}"
        class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white">
        <img src="{{ asset('assets/images/icons/arrow-left.svg') }}" class="w-[28px] h-[28px]" alt="icon">
    </a>
    <div class="flex flex-col items-center">
        <h1 class="font-semibold text-lg">Popular Menus</h1>
    </div>
    <div class="dummy-btn w-12"></div>
</div>

<section id="Result" class=" relative flex flex-col gap-4 px-4 mb-9">
    <div class="grid grid-cols-2 gap-4">
        @foreach ($popularMenus as $menu)
            <div class="flex flex-col rounded-2xl border border-[#F1F2F6] bg-white hover:border-[#ff914d] transition-all duration-300 overflow-hidden">
                <a href="{{ route('menu.show', $menu->slug) }}" class="card">
                <!-- Thumbnail -->
                <div class="relative w-full h-[120px] md:h-[200px] bg-gray-200">
                    <img src="{{ asset('storage/' . $menu->thumbnail) }}"
                         class="w-full h-full object-cover"
                         alt="thumbnail">
    
                    <!-- Sold Count (top-left) -->
                    <span class="absolute top-2 left-2 bg-white text-gray-700 text-xs font-medium px-2 py-1 rounded-lg shadow-sm">
                        {{ $menu->sold_count }} sold
                    </span>
    
                    <!-- Promo Percentage (bottom-right) -->
                    @if($menu->is_promo)
                    <div class="absolute bottom-2 right-2 w-10 h-10">
                        <img src="{{ asset('assets/images/icons/discount-icon.svg') }}" 
                             class="absolute inset-0 w-full h-full" alt="discount">
                        <span class="absolute inset-0 flex items-center justify-center text-xs font-semibold text-white">
                            {{ $menu->percent }}%
                        </span>
                    </div>
                    @endif
                </div>
    
                <!-- Content -->
                <div class="flex flex-col gap-2 p-3">
                    <h3 class="font-semibold text-base line-clamp-2 leading-5 min-h-[40px]">
                        {{ $menu->name }}
                    </h3>
    
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <img src="{{ asset('assets/images/icons/category.svg') }}" class="w-4 h-4" alt="icon">
                        <span>{{ $menu->category->name }}</span>
                    </div>
    
                    <div class="border-t border-gray-100"></div>
    
                    @if($menu->is_promo)
                        <div class="flex flex-col">
                            <!-- Discounted Price -->
                            <span class="font-bold text-lg text-ngekos-orange">
                                Rp {{ number_format($menu->price_after_discount, 0, ',' , '.') }}
                            </span>
                        
                            <!-- Original Price (crossed out) -->
                            <span class="font-medium text-sm text-darkGrey line-through">
                                Rp {{ number_format($menu->price, 0, ',' , '.') }}
                            </span>
                        </div>
                    @else
                        <p class="font-bold text-lg text-ngekos-orange">
                            Rp {{ number_format($menu->price, 0, ',' , '.') }}
                        </p>
                    @endif
                </div>
            </a>
            </div>
        @endforeach
    </div>
    
</section>
@include('includes.navigation')
@endsection