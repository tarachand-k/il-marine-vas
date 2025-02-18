<?php

namespace App\Enums;

enum AssigneeLocationTrackStatus: string
{
    case CMMI = 'CMMI';
    case ROS_2C_MLCE = 'ROS-2C-MLCE';
    case CMCD = 'CMCD';
    case DMC = 'DMC';
}
