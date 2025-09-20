@extends('layouts.app')

@section('content')

<div id="Background" class="absolute top-0 w-full h-[230px] rounded-b-[75px] bg-[linear-gradient(180deg,#FFF3E0_0%,#FFE0C7_100%)]"></div>
  <div id="TopNav" class="relative flex items-center justify-between px-4 my-[30px]">
      <a href="{{ route('home') }}"
          class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white">
          <img src="{{ asset('assets/images/icons/arrow-left.svg') }}" class="w-[28px] h-[28px]" alt="icon">
      </a>
      <div class="flex flex-col items-center">
          <h1 class="font-semibold text-lg">My Order</h1>
      </div>
      <div class="dummy-btn w-14"></div>
  </div>

  <div id="Content" class="relative flex flex-col items-center justify-between gap-5 px-4 mb-5">
    <div class="flex flex-col w-full rounded-xl border border-[#F1F2F6] p-4 gap-4 bg-white shadow">
        {{-- Order Items --}}
        @foreach ($order->orderItems as $item)
        <div class="bg-white p-3 rounded-xl flex items-center justify-between border border-gray-200 shadow-sm hover:shadow-md transition">
            <!-- Thumbnail -->
            <div class="w-24 h-24 flex shrink-0 rounded-xl overflow-hidden border">
                <img src="{{ asset('storage/' . $item->menu->thumbnail) }}" 
                    class="w-full h-full object-cover object-center" 
                    alt="{{ $item->menu->thumbnail }}">
            </div> 
            
            <!-- Item Info -->
            <div class="flex flex-col flex-1 pl-4 gap-2">
            <p class="font-semibold text-gray-900 text-sm md:text-lg">{{ $item->menu->name }}</p>

            <!-- Options -->
            @if($item->orderItemOptions->count())
                <div class="text-xs text-gray-500">
                    @foreach($item->orderItemOptions as $opt)
                        <p>
                            {{ $opt->optionValue->optionGroup->name }}: {{ $opt->optionValue->name }}
                            @if($opt->extra_price > 0)
                                <span class="text-gray-400">(+Rp {{ number_format($opt->extra_price) }})</span>
                            @endif
                        </p>
                    @endforeach
                </div>
            @endif

            <!-- Price + Quantity -->
            <div class="flex justify-between items-center mt-1">
                <p class="font-semibold text-primary text-sm md:text-lg">
                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                </p>

                <!-- Quantity Controls -->
                <div class="flex items-center gap-1">
                    
                    <!-- Quantity -->
                    <span class="w-6 text-center text-md font-medium text-gray-800">
                        Qty:
                    </span>
                    <!-- Quantity -->
                    <span class="w-6 text-center text-lg font-medium text-gray-800">
                        {{ $item->quantity }}
                    </span>

                </div>
            </div>
        </div>
        </div>
        @endforeach
    </div>
    <div class="flex flex-col w-full rounded-xl gap-2 border border-[#F1F2F6] p-4 shadow">
        <p class="font-semibold text-gray-900 text-md">Customer</p>
        
        <div class="flex justify-between text-sm text-gray-700">
            <span>Payment Status</span>
            <span class="font-medium">{{ ucfirst($order->payment_status) }}</span>
        </div>
        <div class="flex justify-between text-sm text-gray-700">
            <span>Order Status</span>
            <span class="font-medium">{{ ucfirst($order->order_status) }}</span>
        </div>
    </div>
    <div class="flex flex-col w-full rounded-xl border border-[#F1F2F6] p-4 shadow font-mono text-sm">
        {{-- Title --}}
        <p class="font-bold text-gray-900 text-base mb-1 text-center uppercase tracking-wider">Order: {{ $order->code }}</p>
        <p class="font-bold text-gray-900 text-base mb-5 text-center uppercase tracking-wider">Table No: {{ $order->table_no }}</p>
    
        {{-- Items --}}
        @foreach ($order->orderItems as $item)
            @php
                $menuPrice = $item->menu->price_after_discount ?? $item->menu->price;
            @endphp
    
            <div class="flex justify-between items-start mb-2">
                {{-- Left side: menu name + base price --}}
                <div class="flex flex-col">
                    <span>
                        {{ $item->menu->name }}
                        <span class="text-gray-500">(Rp {{ number_format($menuPrice, 0, ',', '.') }})</span>
                    </span>
    
                    {{-- Options --}}
                    @if($item->orderItemOptions->count())
                        <div class="ml-2 mt-1 text-gray-500 text-xs">
                            @foreach($item->orderItemOptions as $opt)
                                <p>
                                    - {{ $opt->optionValue->optionGroup->name }}: {{ $opt->optionValue->name }}
                                    @if($opt->extra_price > 0)
                                        (+Rp {{ number_format($opt->extra_price, 0, ',', '.') }})
                                    @endif
                                </p>
                            @endforeach
                        </div>
                    @endif
                </div>
    
                {{-- Right side: qty + subtotal --}}
                <div class="flex flex-col text-right">
                    <span>{{ $item->quantity }}x</span>
                    <span class="font-semibold">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        @endforeach
    
        {{-- Divider --}}
        <hr class="border-gray-300 my-2">
    
        {{-- Totals --}}
        <div class="flex justify-between">
            <span>Subtotal</span>
            <span>Rp {{ number_format($order->orderItems->sum('subtotal'), 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between">
            <span>Tax (11%)</span>
            <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
        </div>
    
        <hr class="border-gray-300 my-2">
    
        <div class="flex justify-between text-base font-bold">
            <span>Total</span>
            <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
        </div>
    </div>
    
    <a href="{{  route('order.receipt', $order->id) }}" class="w-full rounded-xl p-[14px_20px] text-center font-normal text-white bg-ngekos-orange">Download Receipt (PDF)</a>
    <a href="{{ route('home') }}" class="w-full rounded-xl p-[14px_20px] text-center font-normal text-white bg-gray-400">Order Again</a>
    
</div>


@endsection
