<?php

namespace App\Enums;

enum MlceIndentStatus: string
{
    case CREATED = 'Created';
    case IN_PROGRESS = 'In Progress';
    case IN_REVIEW = 'In Review';
    case IN_CLIENT_REVIEW = 'In Client Review';
    case COMPLETED = 'Completed';
}
