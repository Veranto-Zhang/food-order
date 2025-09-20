@extends('layouts.app')

@section('content')
@yield('scripts')

<div id="ForegroundFade"
            class="absolute top-0 w-full h-[100px] bg-[linear-gradient(180deg,#070707_0%,rgba(7,7,7,0)_100%)] z-10">
</div>

        <div id="TopNavAbsolute" class="absolute top-[32px] flex items-center justify-between w-full px-4 z-10">
            <a href="{{ route('home') }}"
                class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white/10 backdrop-blur-sm">
                <img src="{{ asset('assets/images/icons/arrow-left-transparent.svg') }}" class="w-8 h-8" alt="icon">
            </a>
            <p class="font-semibold text-white">Details</p>
            <div class="dummy-btn w-12"></div>
        </div>
  
<div id="Thumbnail" class="w-full overflow-x-hidden">
            <div class="flex shrink-0 w-full h-[360px] ">
                <img src="{{ asset('storage/' . $menu->thumbnail) }}" class="w-full h-full object-cover"
                    alt="thumbnail">
            </div>
</div>

<div id="Content" class="w-full">

    <div id='Price' class="flex flex-col w-full rounded-t-2xl mt-[-20px] bg-white p-4 gap-3">
        <div class="flex items-center justify-between gap-x-4">
            <!-- Title (left) -->
            <h2 class="font-semibold text-xl flex-1 mr-2 break-words">
                {{ $menu->name }}
            </h2>
        
            <!-- Promo badge (right) -->
            @if($menu->is_promo)
                <div class="relative w-14 h-14 flex-shrink-0">
                    <img src="{{ asset('assets/images/icons/discount.svg') }}" 
                         class="w-14 h-14" alt="icon">
                    <span class="absolute inset-0 flex items-center justify-center text-sm font-medium text-white">
                        {{ $menu->percent }}%
                    </span>
                </div>
            @endif
        </div>
        
        <div class="flex flex-row justify-between">
            <div class="flex">
                @if($menu->is_promo)
                                        <div class="flex flex-col">
                                            <!-- Discounted Price -->
                                            <span class="font-semibold text-xl text-orange">
                                                Rp {{ number_format($menu->price_after_discount, 0, ',' , '.') }}
                                            </span>
                                        
                                            <!-- Original Price (crossed out) -->
                                            <span class="font-medium text-sm text-darkGrey line-through">
                                                Rp {{ number_format($menu->price, 0, ',' , '.') }}
                                            </span>
                                        </div>
                                        @else
                                        <p class="font-semibold text-xl text-orange">
                                            Rp {{ number_format($menu->price, 0, ',' , '.') }}
                                        </p>
                                        @endif
            </div>
            <div class="flex items-center gap-2 font-medium text-md text-orange pr-1">
                <img src="{{ asset('assets/images/icons/category-orange.svg') }}" class="w-8 h-8" alt="icon">
                <span>{{ $menu->category->name }}</span>
            </div>

        </div>
    </div>

    <div id="Description" class="flex p-4 pt-0 ">
        <p class="text-sm font-normal text-gray-500 text-justify">
            {{ $menu->description }}.
        </p>
    </div>

    <form action="{{ route('order.cart.add') }}" method="POST">
        @csrf
        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
        <input type="hidden" name="quantity" id="quantity_input" value="1">
    
        <div id="Variants" class="w-full flex flex-col gap-6 px-4">
            @foreach ($menu->menuOptionGroups as $menuOptionGroup)
                @php 
                    $optionGroup = $menuOptionGroup->optionGroup; 
                    $isRequired  = (bool) $optionGroup->is_required; 
                    $maxSelect   = (int)  $optionGroup->max_select; 
                @endphp
            
                <div class="option-group" data-max="{{ $maxSelect }}">
                    <h3 class="mb-2 font-semibold text-gray-900">
                        {{ $optionGroup->name }}
                        @if($isRequired)<span class="text-red-500">*</span>@endif
                    </h3>
            
                    <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
                        @foreach ($optionGroup->optionValues as $value)
                            <li class="w-full border-b border-gray-200 last:border-0">
                                <div class="flex items-center ps-3">
                                    @if($maxSelect === 1)
                                        <input type="radio"
                                               id="option-{{ $optionGroup->id }}-{{ $value->id }}"
                                               name="option_group_{{ $optionGroup->id }}"
                                               value="{{ $value->id }}"
                                               data-extra="{{ $value->extra_price }}"
                                               {{ $isRequired ? 'required' : '' }}
                                               class="w-4 h-4 accent-orange-600">
                                    @else
                                        <input type="checkbox"
                                               id="option-{{ $optionGroup->id }}-{{ $value->id }}"
                                               name="option_group_{{ $optionGroup->id }}[]"
                                               value="{{ $value->id }}"
                                               data-extra="{{ $value->extra_price }}"
                                               class="w-4 h-4 accent-orange-600">
                                    @endif
                                    <label for="option-{{ $optionGroup->id }}-{{ $value->id }}"
                                           class="w-full py-2 ms-2 text-sm font-medium text-gray-900">
                                        {{ $value->name }}
                                        @if($value->extra_price > 0)
                                            <span class="text-xs text-gray-500">(+{{ number_format($value->extra_price, 0) }})</span>
                                        @endif
                                    </label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    
        <!-- Bottom Nav -->
        <div id="BottomNav" class="relative flex w-full h-[180px] shrink-0">
            <nav class="fixed bottom-3 w-full max-w-[640px] px-4 z-10">
              <div class="rounded-[8px] p-4 py-3 bg-[#ff914d]">
                <div class="grid grid-cols-2 items-center mb-3">
                  <div>
                    <p class="text-white text-sm font-medium">Item Quantity</p>
                  </div>
                  <div class="flex items-center justify-end gap-3">
                    <button type="button" id="remove-quantity" class="w-8 h-8 rounded-full bg-white">−</button>
                    <p id="quantity" class="font-medium text-md text-white">1</p>
                    <input type="hidden" name="menuPrice" id="menuPrice" value="{{ $menu->is_promo ? $menu->price_after_discount : $menu->price }}" />
                    <button type="button" id="add-quantity" class="w-8 h-8 rounded-full bg-white">+</button>
                  </div>
                </div>
    
                <button type="submit" class="w-full bg-white text-[#ff914d] font-semibold py-2 rounded">
                    Add to Cart - <span id="subtotal"></span>
                </button>
              </div>
            </nav>
        </div>
    </form>

</div>
@section('scripts')
<script>
    
    document.addEventListener('DOMContentLoaded', function () {
         @if (session()->pull('success'))
        Swal.fire({
            title: 'Added to cart',
            text: "{{ session('success') }}",
            icon: 'success',
            width: '250px',   // 👈 make the box smaller
            padding: '1em',   // optional, reduce inner spacing
            timer: 1500,
            showConfirmButton: false,
            customClass: {
                title: 'text-sm',   // Tailwind or custom CSS class for smaller title
                popup: 'text-xs'    // Tailwind or custom CSS class for smaller popup text
            }
        });
        history.replaceState(null, '', location.href); // ✅ prevents repeat on back
        @endif
    
         @if (session()->pull('error'))
        Swal.fire({
            title: 'Oops',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'OK'
        });
        @endif
    });

    
</script>

<script src="{{ asset('assets/js/booking.js') }}"></script>
@endsection
@endsection