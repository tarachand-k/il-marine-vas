<?php

namespace App\Enums;

enum MlceReportStatus: string
{
    case PENDING = 'Pending';
    case SUBMITTED = 'Submitted';
    case APPROVED = 'Approved';
    case PUBLISHED = 'Published';
}
