@extends('layouts.app')
<style>
    button, input[type="submit"], input[type="reset"] {
        background: none;
        color: inherit;
        border: none;
        padding: 0;
        font: inherit;
        cursor: pointer;
        outline: inherit;
    }
</style>
@section('content')
<body class="">
    <div class="flex items-center justify-center w-full mt-12">
        <div class="flex grid lg:grid-cols-2 gap-20 mx-auto">
            @foreach($products as $key => $product)
                <div class="row align-items-lg-center p-3 shadow align-content-center" style="max-width: 600px; margin: auto">
                    <div class="col-md-3 col-sm-3 align">
                        @if ($file = $product->getProduct()->image)
                            <img src="{{ asset('storage/' .  $file->file_name) }}" width="100" style="max-width: 100%">
                        @else
                            <img src="{{ asset('storage/default_image.png') }}" width="100" style="max-width: 100%">
                        @endif
                    </div>
                    <div class="col-md-3 col-sm-4 text-center">
                        <h4>
                            {{ $product->getProduct()->name }}
                        </h4>
                        <label class="text-secondary">Quantity: {{ $product->getQuantity() }}</label>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <h5>
                            {{ number_format((($product->getPriceGross()->getAmount()) / 100) * $product->getQuantity(), 2, '.', ' ') }} {{ $product->getPriceGross()->getCurrency() }}
                        </h5>
                    </div>
                    <div class="col-md-3 col-sm-1 text-center">
                        <button onclick="removeProduct({{ $product->getProduct()->id }})">
                            <i style="font-size:24px" class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            @endforeach
            <p></p>
            <div class="row">
                <div class="col-md-12 text-center border">
                    <h2>Total amount: {{ $total_amount }} PLN</h2>
                </div>
            </div>
                <p></p>
                <div class="row">
                    <div class="col-md-12 text-center">
                        @if (is_array(session()->get('cart')) && count(session()->get('cart')) > 0)
                            <form action="/order" method="POST" style="display: inline">
                                @csrf
                                <div class="ml-5">
                                    <button type="submit">
                                        <i style="font-size:44px" class="fa fa-shopping-basket"></i>
                                    </button>
                                </div>
                            </form>
                        @endif
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
