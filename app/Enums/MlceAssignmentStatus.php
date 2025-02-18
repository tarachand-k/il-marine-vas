<?php

namespace App\Enums;

enum MlceAssignmentStatus: string
{
    case PENDING = 'Pending';
    case COMPLETED = 'Completed';
    case CANCELLED = "Cancelled";
}
