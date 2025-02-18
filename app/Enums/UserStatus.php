<?php

namespace App\Enums;

enum UserStatus: string
{
    case ACTIVE = 'Active';
    case IN_ACTIVE = 'In-Active';
    case BLOCKED = 'Blocked';
    case UNVERIFIED = 'Unverified';
}
