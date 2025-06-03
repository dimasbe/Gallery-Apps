<?php

namespace App\Enums;

enum KategoriTypeEnum: string
{
    case APLIKASI = 'aplikasi';
    case BERITA = 'berita';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}