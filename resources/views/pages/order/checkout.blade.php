@extends('layouts.app')

@section('content')
<div id="Background" class="absolute top-0 w-full h-[280px] rounded-b-[75px] bg-[linear-gradient(180deg,#FFF3E0_0%,#FFE0C7_100%)]"></div>
  <div id="TopNav" class="relative flex items-center justify-between px-4 my-[30px]">
    <a href="{{ route('show.cart') }}"
        class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white">
        <img src="{{ asset('assets/images/icons/arrow-left.svg') }}" class="w-[28px] h-[28px]" alt="icon">
    </a>
    <div class="flex flex-col items-center">
        <h1 class="font-semibold text-lg">Check Out</h1>
    </div>
    <div class="dummy-btn w-14"></div>
</div>

  <!-- Cust Info -->
  <form action="{{ route('checkout.store') }}" class="relative flex flex-col gap-6 py-4 mb-[100px]" method="POST">
    @csrf
    <div class="px-4">

        <div class="p-5 rounded-xl border border-[#F1F2F6] shadow-sm space-y-2 bg-white">

            <section id="EmptyCart" class="flex flex-col p-2 pb-0 gap-4">
                <div class="w-full h-[360px] flex flex-col gap-[10px] rounded-[22px] items-center overflow-hidden relative">
                <img src="{{ asset('assets/images/payment.png') }}" class="w-full h-full object-cover object-center" alt="background">
                </div>
            </section>
    
            <div id="InputContainer" class="flex flex-col gap-[18px] ">
                
                {{-- Payment Method --}}
                <div class="flex flex-col w-full gap-2">
                    <p class="font-semibold text-lg mt-4">Choose Payment Method</p>

                    <div class="bg-white p-[16px_24px] rounded-[26px] border">
                    <label for="online_payment" class="flex items-center justify-between">
                        <div class="flex items-center">
                        <span class="text-md tracking-035 leading-[22px]">
                            Online Payment
                        </span>
                        </div>
                        <input type="radio" value="online_payment" name="payment_method"  id="online_payment" class="w-5 h-5 appearance-none checked:border-[3px] checked:border-solid checked:border-white rounded-full checked:bg-[#ff914d] ring-2 ring-[#ff914d]">
                    </label>
                    </div>
                    <div class="bg-white p-[16px_24px] rounded-[26px] border">
                    <label for="pay_at_cashier" class="flex items-center justify-between">
                        <div class="flex items-center">
                        <span class="text-md tracking-035 leading-[22px]">
                            Pay at Cashier
                        </span>
                        </div>
                        <input type="radio" value="pay_at_cashier" name="payment_method"  id="pay_at_cashier" class="w-5 h-5 appearance-none checked:border-[3px] checked:border-solid checked:border-white rounded-full checked:bg-[#ff914d] ring-2 ring-[#ff914d]">
                    </label>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Nav -->
    <div id="BottomNav" class="fixed bottom-4 w-full max-w-[640px] mx-auto px-4 z-10">
        <div class="rounded-xl p-4 bg-[#ff914d] flex items-center justify-between shadow-lg">
            <div class="flex flex-col text-white">
                <span class="text-sm">Total</span>
                <span id="grandTotal" class="font-semibold text-lg">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
            </div>
            <button type="submit"
                class="bg-white text-gray-700 px-5 py-3 rounded-lg font-medium shadow hover:bg-orange-100 transition">
                Place Order
            </button>
        </div>
    </div>
</form>


@section('scripts')
{{-- <script src="{{ asset('assets/js/promocode.js') }}"></script> --}}
@endsection
@endsection