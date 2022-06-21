@extends('layouts.app')
<style>
    a { text-decoration: none; }
</style>
@section('content')
    <body class="">
    <div class="flex items-center justify-center w-full mt-12">
        <div class="flex grid lg:grid-cols-2 gap-20 mx-auto">
            @foreach($products as $product)
                <div class="row align-items-lg-center p-3 shadow align-content-center" style="max-width: 600px; margin: auto">
                    <div class="col-md-4 align">
                        @if ($file = $product->image)
                            <img src="{{ asset('storage/' .  $file->file_name) }}" width="150" style="max-width: 100%">
                        @else
                            <img src="{{ asset('storage/default_image.png') }}" width="100" style="max-width: 100%">
                        @endif
                    </div>
                    <div class="col-md-4 text-center">
                        {{ $product->name }}
                        @if ($product->deleted_at)
                            <label class="alert-danger">deleted</label>
                        @endif
                    </div>
                    <div class="col-md-4 text-center">
                        <a href="/products/{{ $product->id }}" style="text-decoration: none; color: rgb(0,0,0);">
                            <i class="fa fa-edit"></i>
                        </a>
                    </div>
                </div>
            @endforeach
            <p></p>
            <div class="row">
                <div class="col-md-12 text-center border">
                    <h2>Products count: {{ $products->count() }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="/products/add" style="text-decoration: none; color: rgb(0,0,0);">
                        <i class="fa fs-1 fa-plus mt-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
@endsection
