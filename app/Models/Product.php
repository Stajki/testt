<?php

namespace App\Models;

use App\Casts\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $casts = [
        'price_nett' => Money::class,
        'price_gross' => Money::class,
    ];

    protected $fillable = [
        'name',
        'available_stock',
        'price_nett',
        'price_gross',
    ];

    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'default_image_id');
    }
}
