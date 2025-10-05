<?php

namespace App\Enums;

enum MetodePembayaran: string
{
    case TUNAI = 'tunai';
    case NON_TUNAI = 'non tunai';
}