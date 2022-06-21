@extends('layouts.app')
@section('content')
<body class="">
    <div class="flex items-center justify-center w-full mt-12">
        <div class="flex grid lg:grid-cols-2 gap-20 mx-auto">
            <form action="">
                <input class="form-control text-center" name="query" type="text" placeholder="Product name ..." value="{{ request()->get('query') }}">
                <center>
                    <button class="btn btn-secondary mt-1" type="submit">
                        Search
                    </button>
                </center>
            </form>
            <div class="row">
                @foreach($products as $key => $product)
                    <div class="col-md-3 col-sm-6 col-sm-1">
                        <div class="d-flex justify-content-center container mt-5">
                            <div class="card p-3 bg-white">
                                <div class="about-product text-center mt-2">
                                    @if ($file = $product->image)
                                        <img src="{{ asset('storage/' .  $file->file_name) }}" width="300" style="max-width: 100%">
                                    @else
                                        <img src="{{ asset('storage/default_image.png') }}" width="300" style="max-width: 100%">
                                    @endif
                                    <p></p>
                                    <div>
                                        <h4 class="product-name">{{ $product->name }}</h4>
                                        <h6 class="mt-0 text-black-50">Available stock: {{ $product->available_stock }}</h6>
                                    </div>
                                </div>
                                <div class="stats mt-2">
                                    <div class="d-flex justify-content-between p-price"><span>Price nett</span><span>{{number_format(($product->price_nett->getAmount()) / 100, 2, '.', ' ')}} {{$product->price_nett->getCurrency()}}</span></div>
                                    <div class="d-flex justify-content-between p-price"><span>Price gross</span><span>{{number_format(($product->price_gross->getAmount()) / 100, 2, '.', ' ')}} {{$product->price_gross->getCurrency()}}</span></div>
                                </div>
                                <div class="d-flex justify-content-between total font-weight-bold mt-4">
                                    <input type="number" id="quantity_{{ $product->id }}" name="quantity" value="{{ session()->get('cart')[$product->id]['quantity'] ?? 0 }}" min="0" max="{{ $product->available_stock }}">
                                    <button type="button" id="add-to-cart" class="btn btn-sm btn-outline-secondary" onclick="addProduct(this)" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price_nett="{{ $product->price_nett->getAmount() / 100 }}" data-price_gross="{{ $product->price_gross->getAmount() / 100 }}">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($key % 3 === 0 && $key !== 0)
                        </div>
                        <div class="row">
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function() {
        window.addProduct = function(event) {
            var productId = event.dataset.id;
            jQuery.ajax('/cart/product/' + productId, {
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "quantity": jQuery('#quantity_' + productId).val()
                },
                success: function (data, status, xhr) {
                    jQuery('#items-in-cart').html(data['total_quantity']);
                    showSnackbar(data['message'] ?? 'Success');
                }
            });
        }
    })
</script>
