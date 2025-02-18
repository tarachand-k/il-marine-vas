<?php

namespace App\Enums;

enum MlceReportStatus: string
{
    case SUBMITTED = 'Submitted';
    case APPROVED = 'Approved';
    case PUBLISHED = 'Published';
}
