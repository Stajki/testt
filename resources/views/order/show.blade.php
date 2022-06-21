@extends('layouts.app')
@section('content')
<body class="">
    <div class="flex items-center justify-center w-full mt-12">
        <div class="row">
            <div class="col-md-12 text-center">
                <h3>{{ $order->order_number }}</h3>
            </div>
        </div>
        <div class="flex grid lg:grid-cols-2 gap-20 mx-auto">
            @foreach($items as $key => $item)
                <div class="row align-items-lg-center p-3 shadow align-content-center" style="max-width: 600px; margin: auto">
                    <div class="col-md-4 align">
                        @if ($file = $item->product->image)
                            <img src="{{ asset('storage/' .  $file->file_name) }}" width="100" style="max-width: 100%">
                        @else
                            <img src="{{ asset('storage/default_image.png') }}" width="100" style="max-width: 100%">
                        @endif
                    </div>
                    <div class="col-md-4 text-center">
                        <h4>
                            {{ $item->product->name }}
                        </h4>
                        <label class="text-secondary">Quantity: {{ $item->quantity }}</label>
                    </div>
                    <div class="col-md-4">
                        <h5>
                            {{number_format((($item->price_gross->getAmount()) / 100) * $item->quantity, 2, '.', ' ')}} {{$item->price_gross->getCurrency()}}
                        </h5>
                    </div>
                </div>
            @endforeach
            <p></p>
            <div class="row">
                <div class="col-md-12 text-center border">
                    <h2>Order value: {{ number_format(($order->total_price_gross->getAmount()) / 100, 2, '.', ' ') }} {{ $order->total_price_gross->getCurrency() }}</h2>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function () {
        window.removeProduct = function (id) {
            jQuery.ajax('/cart/product/' + id, {
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "quantity": 0,
                },
                success: function (data, status, xhr) {
                    location.reload();
                }
            });
        }
    })
</script>
