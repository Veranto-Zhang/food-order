<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt</title>
    <style>
        @page {
            margin: 6px;
            size: 58mm 200mm;
        }
        body {
            font-family: monospace, sans-serif;
            font-size: 10px;
            padding: 4px;
        }

        .wrapper {
            width: 190px; /* ≈ 58mm */
            margin: 0 auto;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 4px;
        }
        .line {
            border-top: 1px dashed #000;
            margin: 3px 0;
        }
        .row {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }
        .item-name {
            max-width: 120px;
            word-wrap: break-word;
        }
        .options {
            margin-left: 6px;
            font-size: 9px;
            color: #444;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="title">ORDER RECEIPT</div>
    <div style="text-align:center;">
        {{ $order->code }} | {{ $order->transaction_date }}
    </div>
    <div style="text-align:center; margin-bottom:8px;">
        Table {{ $order->table_no }}
    </div>

    <div class="line"></div>

    @foreach ($order->orderItems as $item)
        @php
            $menuPrice = $item->menu->price_after_discount ?? $item->menu->price;
        @endphp
        <div class="row">
            <div class="item-name">
                {{ $item->menu->name }} ({{ number_format($menuPrice, 0, ',', '.') }})
            </div>
            <div>
                {{ $item->quantity }}x {{ number_format($item->subtotal, 0, ',', '.') }}
            </div>
        </div>
        @if($item->orderItemOptions->count())
            <div class="options">
                @foreach($item->orderItemOptions as $opt)
                    - {{ $opt->optionValue->optionGroup->name }}: {{ $opt->optionValue->name }}
                    @if($opt->extra_price > 0)
                        (+{{ number_format($opt->extra_price, 0, ',', '.') }})
                    @endif
                    <br>
                @endforeach
            </div>
        @endif
        <div class="line"></div>
    @endforeach

    <div class="row">
        <span>Subtotal</span>
        <span>{{ number_format($order->orderItems->sum('subtotal'), 0, ',', '.') }}</span>
    </div>
    <div class="row">
        <span>Tax (11%)</span>
        <span>{{ number_format($order->tax, 0, ',', '.') }}</span>
    </div>
    <div class="line"></div>
    <div class="row">
        <strong>Total</strong>
        <strong>{{ number_format($order->total_amount, 0, ',', '.') }}</strong>
    </div>
    <div class="line"></div>

    <div class="row">
        <span>Payment</span>
        <span>{{ ucfirst($order->payment_status) }}</span>
    </div>
    <div style="text-align:center; margin-top:10px;">
        Thank you for your visit!
    </div>
</div>
</body>
</html>
