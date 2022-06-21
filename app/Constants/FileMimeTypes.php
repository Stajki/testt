<?php

declare(strict_types=1);

namespace App\Constants;

class FileMimeTypes
{
    public const JPEG = 'image/jpeg';
    public const PNG = 'image/png';

    public const SUPPORTED = [
        self::JPEG,
        self::PNG,
    ];
}
