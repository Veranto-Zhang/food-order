@extends('layouts.app')
@section('content')

    @if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
    @endif

    <!-- Scan State -->
        <section id="Scan" class="flex flex-col p-4 gap-4 my-auto">
            <div class="w-full h-[460px] flex flex-col gap-[10px] items-center overflow-hidden relative">
              <img src="{{ asset('assets/images/scan-qr.png') }}" class="w-full h-full object-cover object-center" alt="background">
              <p class="text-gray-500 text-lg text-center">Please scan the QR code at your table to continue</p>
            </div>
        </section>

@endsection