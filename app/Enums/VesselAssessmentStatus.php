<?php

namespace App\Enums;

enum VesselAssessmentStatus: string
{
    case INITIALIZED = 'Initialized';
    case ASSIGNED = 'Assigned';
    case IN_PROGRESS = 'In Progress';
    case SUBMITTED = 'Submitted';
    case COMPLETED = 'Completed';
}