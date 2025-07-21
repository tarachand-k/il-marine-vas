<?php


namespace App\Enums;

enum VesselAssessmentLoadType: string
{
    case FULL_LOAD = 'Full Load';
    case PARTIAL = 'Partial';
    case COMMINGLE_LOAD = 'Commingle Load';
}
