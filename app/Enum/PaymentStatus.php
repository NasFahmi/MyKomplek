<?php
namespace App\Enum;

enum PaymentStatus: string
{
    case Lunas = 'lunas';
    case BelumLunas = 'belum_lunas';
}