<?php

namespace App\Casts;

use Money\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Money implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     *
     * @return \Money\Money
     */
    public function get($model, $key, $value, $attributes): ?\Money\Money
    {
        if (!$value) {
            return null;
        }

        $attributes = json_decode($value, true);

        return new \Money\Money($attributes['amount'], new Currency($attributes['currency']));
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model $model
     * @param string $key
     * @param array $value
     * @param array $attributes
     *
     * @return string
     */
    public function set($model, $key, $value, $attributes): ?string
    {
        if (!$value) {
            return null;
        }

        /** @var $value \Money\Money */
        return json_encode($value->jsonSerialize());
    }
}
