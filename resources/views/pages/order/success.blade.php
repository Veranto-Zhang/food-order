@extends('layouts.app')

@section('content')
<div id="Background" class="absolute top-0 w-full h-[280px] rounded-b-[75px] bg-[linear-gradient(180deg,#FFF3E0_0%,#FFE0C7_100%)]"></div>

    <div class="relative flex flex-col gap-[20px] py-[20px] px-4">

            <div>
                <h1 class="font-semibold text-[28px] leading-[45px] text-center">Order Successful</h1>
                
                @if ($order->payment_method == 'pay_at_cashier')
                <p class="font-semibold text-[16px] text-center">
                    Please pay your order at the Cashier
                </p>
                @else
                    <h1 class="font-semibold text-[28px] leading-[45px] text-center">
                    Thank you!
                    </h1>
                @endif
            </div>
                
                <section id="EmptyCart" class="flex flex-col p-5 pb-2 gap-4">
                    <div class="w-full h-[240px] flex flex-col gap-[10px] rounded-[22px] items-center overflow-hidden relative">
                    <img src="{{ asset('assets/images/order.png') }}" class="w-full h-full object-cover object-center" alt="background">
                    </div>
                </section>

        <div id="Content" class="relative flex flex-col items-center justify-between gap-5">
            <div class="flex flex-col w-full rounded-xl gap-2 border border-[#F1F2F6] p-4 shadow">
                <p class="font-semibold">Your Order Code</p>
                <div class="flex items-center w-full justify-between rounded-xl p-4 gap-2 border border-[#F1F2F6] bg-white">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('assets/images/icons/order-orange.svg') }}" class="w-5 h-5 flex shrink-0" alt="icon">
                        <p id="orderCode" class="font-medium">{{ $order->code }}</p>
                    </div>
                    <button 
                    type="button" 
                    onclick="copyOrderCode()" 
                    class="text-gray-500 hover:text-primary transition"
                    title="Copy code"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                    </svg>
                  
                </button>
                </div>
                
            </div>
            <form action="{{ route('check-order.show') }}" method="POST" class="w-full">
                @csrf
                <input type="hidden" name="code" value="{{ $order->code }}">
                <button type="submit" class="w-full rounded-xl p-[14px_20px] text-center font-normal text-white bg-ngekos-orange">
                    View my order
                </button>
            </form>
            <a href="{{ route('home') }}" class="w-full rounded-xl p-[14px_20px] text-center font-normal text-white bg-gray-400">Order Again</a>
            
        </div>
        </div>
        

                    
@section('scripts')
<script>
    function copyOrderCode() {
        const code = document.getElementById('orderCode').innerText;
        navigator.clipboard.writeText(code).then(() => {
            alert("Order code copied: " + code);
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    }
</script>
@endsection
@endsection