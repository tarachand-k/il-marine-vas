<?php

namespace App\Enums;

enum CapitalInvolvement: string
{
    case NO = 'No';
    case MINOR = 'Minor';
    case MODERATE = 'Moderate';
    case MAJOR = 'Major';
}
