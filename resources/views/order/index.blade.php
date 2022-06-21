@extends('layouts.app')
<style>
    a { text-decoration: none; }
</style>
@section('content')
<body class="">
    <div class="flex items-center justify-center w-full mt-12">
        <div class="flex grid lg:grid-cols-2 gap-20 mx-auto">
            @foreach($orders as $order)
                <div class="row align-items-lg-center p-3 shadow align-content-center" style="max-width: 600px; margin: auto">
                    <div class="col-md-4 align">
                        No: {{ $order->order_number }}
                    </div>
                    <div class="col-md-4 text-center">
                        Order value: {{ number_format(($order->total_price_gross->getAmount()) / 100, 2, '.', ' ') }} {{ $order->total_price_gross->getCurrency() }}
                    </div>
                    <div class="col-md-4 text-center">
                        <a href="/order/{{ $order->id }}" style="text-decoration: none; color: rgb(0,0,0);">
                            <i class="fa fa-eye"></i>
                        </a>
                    </div>
                </div>
            @endforeach
            <p></p>
            <div class="row">
                <div class="col-md-12 text-center border">
                    <h2>Orders count: {{ $orders->count() }}</h2>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
@endsection
