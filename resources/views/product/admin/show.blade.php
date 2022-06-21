@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Show product</div>

                    <div class="card-body">
                        <form enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $product->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="available-stock" class="col-md-4 col-form-label text-md-end">Available stock</label>

                                <div class="col-md-6">
                                    <input id="available-stock" type="number" min="0" class="form-control @error('email') is-invalid @enderror" name="available-stock" value="{{ $product->available_stock }}" required>

                                    @error('available-stock')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="price-nett" class="col-md-4 col-form-label text-md-end">Price nett</label>

                                <div class="col-md-6">
                                    <input id="price-nett" type="number" min="0" step=0.01 class="form-control @error('price-nett') is-invalid @enderror" name="price-nett" value="{{ $product->price_nett->getAmount() / 100 }}" required>

                                    @error('price-nett')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="price-gross" class="col-md-4 col-form-label text-md-end">Price gross</label>

                                <div class="col-md-6">
                                    <input id="price-gross" type="number" min="0" step=0.01 class="form-control @error('price-gross') is-invalid @enderror" name="price-gross" value="{{ $product->price_gross->getAmount() / 100 }}" required>

                                    @error('price-gross')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="image" class="col-md-4 col-form-label text-md-end">Default photo</label>

                                <div class="col-md-6">
                                    <input type="file" name="image[]" accept="image/*" class="@error('image') is-invalid @enderror">

                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary" formaction="/products/{{ $product->id }}/update">
                                        Save
                                    </button>
                                    @if (!$product->deleted_at)
                                        <button type="submit" class="btn btn-danger" formaction="/products/{{ $product->id }}/delete">
                                            Delete
                                        </button>
                                    @endif
                                    @if ($product->deleted_at)
                                        <button type="submit" class="btn btn-info" formaction="/products/{{ $product->id }}/restore">
                                            Restore
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
