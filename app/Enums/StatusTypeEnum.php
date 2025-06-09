<?php

namespace App\Enums;

enum StatusTypeEnum: string
{
    case PENDING = 'pending';
    case DITERIMA = 'diterima';
    case DITOLAK = 'ditolak';

    public function values(): array {
        return array_column(self::cases(), 'value');
    }
}