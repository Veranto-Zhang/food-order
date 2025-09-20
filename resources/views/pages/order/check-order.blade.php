@extends('layouts.app')

@section('content')
<div id="Background" class="absolute top-0 w-full h-[280px] rounded-b-[75px] bg-[linear-gradient(180deg,#FFF3E0_0%,#FFE0C7_100%)]"></div>
        <div class="relative flex flex-col gap-[30px] my-[60px] px-4">

            <h1 class="font-semibold text-[28px] leading-[45px] text-center">Check Your Order</h1>

            <form action="{{ route('check-order.show') }}"
                class="flex flex-col rounded-[30px] border border-[#F1F2F6] p-5 gap-6 bg-white" method="POST">
                    @csrf
                <div class="flex flex-col gap-[6px]">
                    <h1 class="font-semibold text-lg">Your Informations</h1>
                    <p class="text-sm text-gray-500">Fill the fields below with your valid data</p>
                </div>
                <div id="InputContainer" class="flex flex-col gap-[18px]">
                    <div class="flex flex-col w-full gap-2">
                        <p class="font-semibold">Order Code</p>
                        <label
                            class="flex items-center w-full rounded-full p-[14px_20px] gap-3 bg-white ring-1 ring-[#F1F2F6] focus-within:ring-[#ff914d] transition-all duration-300">
                            <img src="assets/images/icons/note-favorite-grey.svg" class="w-5 h-5 flex shrink-0"
                                alt="icon">
                            <input type="text" name="code" id="code"
                                class="appearance-none outline-none w-full font-semibold placeholder:text-gray-500 placeholder:font-normal"
                                placeholder="Write your order code" value="{{ old('code') }}">
                        </label>
                        @error('code')
                                    <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    @if (session('error'))
                        <p class="text-center text-red-500"> {{ session('error') }}</p>
                    @endif

                    <button type="submit"
                        class="flex w-full justify-center rounded-full p-[14px_20px] bg-ngekos-orange font-semibold text-white">View
                        My Order</button>
                </div>
            </form>
        </div>
        @include('includes.navigation')
@endsection