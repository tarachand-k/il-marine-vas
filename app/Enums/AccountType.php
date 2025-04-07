<?php

namespace App\Enums;

enum AccountType: string
{
    case CORPORATE = 'Corporate';
    case RETAIL = 'Retail';
    case UW = 'U/W';
}
