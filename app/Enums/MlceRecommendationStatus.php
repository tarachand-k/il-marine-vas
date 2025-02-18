<?php

namespace App\Enums;

enum MlceRecommendationStatus: string
{
    case PENDING = 'Pending';
    case IN_PROGRESS = 'In progress';
    case IMPLEMENTED = 'Implemented';
    case REJECTED = 'Rejected';
}
