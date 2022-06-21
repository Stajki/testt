<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Money\Money;
use Money\Currency;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('name');
            $table->unsignedBigInteger('available_stock')->default(0);
            $table->unsignedBigInteger('default_image_id')->nullable();
            $table->json('price_nett');
            $table->json('price_gross');

            $table->foreign('default_image_id')->references('id')->on('files');
        });

        $this->createProducts();
    }

    private function createProducts(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $price = $i * 100;
            $priceNett = new Money($price, new Currency('PLN'));
            $priceGross = $priceNett->multiply(1.23);

            Product::create([
                'name' => 'Product ' . $i,
                'available_stock' => $i,
                'price_nett' => $priceNett,
                'price_gross' => $priceGross,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
