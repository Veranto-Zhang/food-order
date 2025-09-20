@extends('layouts.app')

@section('content')

        <!-- Header -->
         <div class="flex items-center justify-between px-4 mt-10">
            <!-- Left: burger + text -->
            <div class="flex items-center gap-2">
                <!-- Burger -->
                <img src="{{ asset('assets/images/logo.png') }}" alt="icon" class="h-14 flex-shrink-0 rounded-xl">

                <!-- Text stacked vertically -->
                <div class="flex flex-col">
                    <p class="text-darkGrey text-sm">Welcome,</p>
                    <h1 class="font-semibold text-md">Good Food Awaits</h1>
                </div>
            </div>

            <!-- Right: circle with text --> 
            <div class="flex flex-col items-center">
                <!-- Text above the circle -->
                <p class="mb-[-16px] text-[#ff914d] font-semibold">{{ $tableNumber }}</p>
                
                <!-- Circle with image and text inside -->
                <div class="relative w-16 h-16">
                    <!-- Background image -->
                    <img src="{{ asset('assets/images/table.png') }}" alt="circle image" class="w-full h-full object-cover">
                    
                </div>
            </div>
        </div>


        <div id="Categories" class="swiper w-full overflow-x-hidden mt-[30px] flex flex-col gap-4">
            <div class="flex items-center justify-between px-5">
                <h2 class="font-medium text-lg">Categories</h2>
            </div>

            <div class="swiper-wrapper">

                @foreach ($categories as $category)

                <div class="swiper-slide !w-fit pb-[30px]">
                    <a href="{{ route('category.show', $category->slug) }}" class="card group">
                        <div class="flex flex-row items-center border border-[#d9d9d9] shrink-0 rounded-[12px] p-4 gap-2 shadow-sm bg-white text-center group-hover:border-[#ff914d] ">
                            <div class="w-6 h-6 flex shrink-0">
                                <img src="{{ asset('storage/' . $category->image) }}" alt="icon" class=" rounded-2xl">
                              </div>
                              <span class="text-sm tracking-[0.35px] text-gray-700  transition-all duration-100 group-hover:text-[#ff914d]">
                                {{ $category->name }}
                              </span>
                        </div>
                    </a>
                </div>
                @endforeach

            </div>
        </div>

        <section id="Promo" class="flex flex-col gap-4">
            <div class="flex items-center justify-between px-5">
                <h2 class="font-medium text-lg">Today's Promo</h2>
                <a href="{{ route('pages.menu.promo') }}">
                    <div class="flex items-center gap-2">
                        <span>See all</span>
                        <img src=" {{ asset('assets/images/icons/arrow-right.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    </div>
                </a>
            </div>

            <div class="swiper w-full overflow-x-hidden">
                <div class="swiper-wrapper">
                    @foreach ($promoMenus as $menu)
                    <div class="swiper-slide !w-fit">
                        <a href="{{ route('menu.show', $menu->slug) }}" class="card">
                            <div
                                class="flex flex-col w-[220px] shrink-0 rounded-2xl border border-[#F1F2F6] bg-white hover:border-[#ff914d] transition-all duration-300 overflow-hidden">
            
                                <!-- Thumbnail -->
                                <div class="relative w-full h-[150px] bg-gray-200">
                                    <img src="{{ asset('storage/' . $menu->thumbnail) }}"
                                         class="w-full h-full object-cover"
                                         alt="thumbnail">
            
                                    <!-- Sold Count (top-left) -->
                                    <span class="absolute top-2 left-2 bg-white text-gray-700 text-xs font-medium px-2 py-1 rounded-lg shadow-sm">
                                        {{ $menu->sold_count }} sold
                                    </span>
            
                                    <!-- Promo Percentage (bottom-right) -->
                                    @if($menu->percent > 0)
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
                                <div class="flex flex-col gap-2 p-4">
                                    <h3 class="font-semibold text-base line-clamp-2 leading-5 min-h-[40px]">
                                        {{ $menu->name }}
                                    </h3>
            
                                    <div class="flex items-center gap-2 text-sm text-gray-500">
                                        <img src="{{ asset('assets/images/icons/category.svg') }}" class="w-4 h-4" alt="icon">
                                        <span>{{ $menu->category->name }}</span>
                                    </div>
            
                                    <div class="mt-2 border-t border-gray-100"></div>
            
                                    
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
            
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="Banner" class="flex flex-col p-5 gap-4 bg-[#F5F6F8] mt-[30px]">
            <a href="{{ route('pages.menu.all') }}">
                <div class="w-full h-[130px] flex flex-col gap-[10px] rounded-[22px] items-center overflow-hidden relative">
                  <img src="{{ asset('assets/images/banner.png') }}" class="w-full h-full object-cover object-center" alt="background">
                  <div class="absolute z-10 flex flex-col gap-[10px] transform -translate-y-1/2 top-1/2 left-4">
                    <p class="text-white font-semibold">Hungry for More?<br>Explore All Our Dishes!</p>
                    <p class="bg-white p-[8px_24px] rounded-[10px] text-ngekos-orange font-semibold text-xs w-fit">View All Menus</p>
                  </div>
                </div>
            </a>
        </section>


        <section id="Popular" class="flex flex-col gap-4 mt-[30px]">
            <div class="flex items-center justify-between px-5">
                <h2 class="font-medium text-lg">Popular Menu</h2>
                <a href="{{ route('pages.menu.popular') }}">
                    <div class="flex items-center gap-2">
                        <span>See all</span>
                        <img src="{{ asset('assets/images/icons/arrow-right.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    </div>
                </a>
            </div>
            
            <div class="swiper w-full overflow-x-hidden">
                <div class="swiper-wrapper">
                    @foreach ($popularMenus as $menu)
                    <div class="swiper-slide !w-fit">
                        <a href="{{ route('menu.show', $menu->slug) }}" class="card">
                            <div
                                class="flex flex-col w-[220px] shrink-0 rounded-2xl border border-[#F1F2F6] bg-white hover:border-[#ff914d] transition-all duration-300 overflow-hidden">
            
                                <!-- Thumbnail -->
                                <div class="relative w-full h-[150px] bg-gray-200">
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
                                <div class="flex flex-col gap-2 p-4">
                                    <h3 class="font-semibold text-base line-clamp-2 leading-5 min-h-[40px]">
                                        {{ $menu->name }}
                                    </h3>
            
                                    <div class="flex items-center gap-2 text-sm text-gray-500">
                                        <img src="{{ asset('assets/images/icons/category.svg') }}" class="w-4 h-4" alt="icon">
                                        <span>{{ $menu->category->name }}</span>
                                    </div>
                                    
            
                                    <div class="mt-2 border-t border-gray-100"></div>
            
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
            
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        @include('includes.navigation')

@endsection