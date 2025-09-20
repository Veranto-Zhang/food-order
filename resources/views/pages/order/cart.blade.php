@extends('layouts.app')

@section('content')

  <div id="Background" class="absolute top-0 w-full h-[230px] rounded-b-[75px] bg-[linear-gradient(180deg,#FFF3E0_0%,#FFE0C7_100%)]"></div>
  <div id="TopNav" class="relative flex items-center justify-between px-4 my-[30px]">
      <a href="{{ route('home') }}"
          class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white">
          <img src="{{ asset('assets/images/icons/arrow-left.svg') }}" class="w-[28px] h-[28px]" alt="icon">
      </a>
      <div class="flex flex-col items-center">
          <h1 class="font-semibold text-lg">Your Cart</h1>
      </div>
      <div class="dummy-btn w-14"></div>
  </div>

  @livewire('cart-component')

@section('scripts')
<script src="{{ asset('assets/js/cart.js') }}"></script>
@endsection
@endsection
