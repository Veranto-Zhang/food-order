<div id="BottomNav" class="relative flex w-full h-[100px] shrink-0">
    <nav class="fixed bottom-0 w-full max-w-[640px] z-10">
        <div class="grid grid-cols-4 h-fit rounded-t-[32px] justify-between p-4 bg-white border border-gray-200">

            @if (request()->routeIs('home'))
                <a href="{{ route('home') }}" class="flex flex-col items-center text-center gap-2">
                    <img src="{{ asset('assets/images/icons/home-orange.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <span class="font-semibold text-sm text-ngekos-orange">Home</span>
                </a>
            @else
                <a href="{{ route('home') }}" class="flex flex-col items-center text-center gap-2">
                    <img src="{{ asset('assets/images/icons/home.svg') }}" class="w-6 h-6 flex shrink-0 opacity-40" alt="icon">
                    <span class="font-semibold text-sm text-gray-400">Home</span>
                </a>
            @endif

            @if (request()->routeIs('show.cart'))
            <a href="{{ route('show.cart') }}" class="flex flex-col items-center text-center gap-2">
                <img src="{{ asset('assets/images/icons/cart-orange.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                <span class="font-semibold text-sm text-ngekos-orange">Cart</span>
            </a>
            @else
            <a href="{{ route('show.cart') }}" class="flex flex-col items-center text-center gap-2">
                <img src="{{ asset('assets/images/icons/cart.svg') }}" class="w-6 h-6 flex opacity-40 shrink-0" alt="icon">
                <span class="font-semibold text-sm text-gray-400">Cart</span>
            </a>
            @endif

            @if (request()->routeIs('pages.menu.all'))
                <a href="{{ route('pages.menu.all') }}" class="flex flex-col items-center text-center gap-2">
                    <img src="{{ asset('assets/images/icons/search-orange.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <span class="font-semibold text-sm text-ngekos-orange">All Menu</span>
                </a>
            @else
                <a href="{{ route('pages.menu.all') }}" class="flex flex-col items-center text-center gap-2">
                    <img src="{{ asset('assets/images/icons/search.svg') }}" class="w-6 h-6 flex shrink-0 opacity-40" alt="icon">
                    <span class="font-semibold text-sm text-gray-400">All Menu</span>
                </a>
            @endif

            <a href="{{ route('check-order') }}" class="flex flex-col items-center text-center gap-2">
                <img src="{{ asset('') }}assets/images/icons/order{{ request()->routeIs('help') ? '-orange' : '' }}.svg" class="w-6 h-6 flex shrink-0 opacity-40" alt="icon">
                <span class="font-semibold text-sm text-gray-400">Order</span>
            </a>
        </div>
    </nav>
</div>