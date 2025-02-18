<?php

namespace App\Enums;

enum MlceRecommendationTimeline: string
{
    case DAYS_7 = '7 days';
    case DAYS_30 = '30 days';
    case DAYS_45 = '45 days';
    case DAYS_90 = '90 days';
}
