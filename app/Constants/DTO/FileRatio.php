<?php

namespace App\Constants\DTO;

class FileRatio
{
    protected $min;
    protected $max;

    public function __construct(float $min = 1.0, float $max = 1.0)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function getMin(): float
    {
        return $this->min;
    }

    public function getMax(): float
    {
        return $this->max;
    }
}
