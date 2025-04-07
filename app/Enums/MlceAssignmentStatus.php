<?php

namespace App\Enums;

enum MlceAssignmentStatus: string
{
    case ASSIGNED = 'Assigned';
    case MOBILISED = 'Mobilised';
    case SURVEY_STARTED = "Survey Started";
    case SURVEY_COMPLETED = "Survey Completed";
    case DEMOBILISED = "Demobilised";
    case RECOMMENDATIONS_SUBMITTED = "Recommendations Submitted";
}
