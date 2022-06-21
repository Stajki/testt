<?php

namespace App\Constants;

class ImageMimeTypes
{
    public const JPEG = 'image/jpeg';
    public const PNG = 'image/png';
    public const BMP = 'image/bmp';
    public const GIF = 'image/gif';
    public const JPG = 'image/jpg';
    public const JFIF = 'image/jfif';
    public const PJPG = 'image/pjpg';
    public const PJP = 'image/pjp';

    public const SUPPORTED = [
        self::JPEG, self::PNG, self::BMP, self::GIF, self::JPG, self::JFIF,
        self::PJPG, self::PJP,
    ];
}
