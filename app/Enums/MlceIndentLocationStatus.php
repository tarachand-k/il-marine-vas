<?php

namespace App\Enums;

enum MlceIndentLocationStatus: string
{
    case NOT_ASSIGNED = 'Not Assigned';
    case PENDING = 'Pending';
    case COMPLETED = 'Completed';
    case CANCELLED = 'Cancelled';
}
