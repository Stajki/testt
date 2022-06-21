<?php

namespace App\Http\Controllers;

use App\Constants\AccountTypes;
use App\Models\Product;
use App\Models\User;
use App\Services\UploadFileService;
use Illuminate\Http\Request;
use Money\Currency;
use Money\Money;

class ProductController extends Controller
{
    public function show(int $productId)
    {
        $product = Product::withTrashed()->findOrFail($productId);

        return view('product.admin.show', [
            'product' => $product,
        ]);
    }

    public function index(Request $request)
    {
        $user = User::findCurrent();
        $builder = Product::query();
        if ($request->filled('query')) {
            $query = $request->get('query');
            $builder->whereRaw('lower(name) like (?)', ['%' . str_replace(' ', '_', $query) . '%']);
        }

        if ($user->account_type == AccountTypes::USER) {
            return view('product.index', [
                'products' => $builder->get(),
            ]);
        }

        return view('product.admin.index', [
            'products' => $builder->withTrashed()->get(),
        ]);
    }

    public function store(Request $request, UploadFileService $uploadFileService)
    {
        $this->validate($request, [
            'name' => ['required', 'string'],
            'available-stock' => ['required', 'integer'],
            'price-nett' => ['required', 'numeric'],
            'price-gross' => ['required', 'numeric'],
        ]);

        /** @var Product $product */
        $product = Product::create([
            'name' => $request->input('name'),
            'available_stock' => $request->input('available-stock'),
            'price_nett' => new Money($request->input('price-nett') * 100, new Currency('PLN')),
            'price_gross' => new Money($request->input('price-gross') * 100, new Currency('PLN')),
        ]);

        if ($image = $request->file('image')) {
            $image = $image[0];
            $file = $uploadFileService->uploadImage($image, 'PRODUCT_IMAGE');
            $product->image()->associate($file);
            $product->save();
        }

        return redirect('/products/' . $product->id);
    }

    public function update(Request $request, int $productId, UploadFileService $uploadFileService)
    {
        $this->validate($request, [
            'name' => ['required', 'string'],
            'available-stock' => ['required', 'integer'],
            'price-nett' => ['required', 'numeric'],
            'price-gross' => ['required', 'numeric'],
        ]);

        $product = Product::withTrashed()->findOrFail($productId);
        $product->update([
            'name' => $request->input('name'),
            'available_stock' => $request->input('available-stock'),
            'price_nett' => new Money($request->input('price-nett') * 100, new Currency('PLN')),
            'price_gross' => new Money($request->input('price-gross') * 100, new Currency('PLN')),
        ]);

        if ($image = $request->file('image')) {
            $image = $image[0];
            $file = $uploadFileService->uploadImage($image, 'PRODUCT_IMAGE');
            $product->image()->associate($file);
            $product->save();
        }

        return redirect('/products/' . $product->id);
    }

    public function destroy(int $productId)
    {
        /** @var Product $product */
        $product = Product::findOrFail($productId);
        $product->delete();

        return redirect('/products');
    }

    public function restore(int $productId)
    {
        /** @var Product $product */
        $product = Product::withTrashed()->findOrFail($productId);
        $product->restore();

        return redirect('/products');
    }
}
