<?php

namespace App\Enums;

enum UserRole: string
{
    case ILGIC_MLCE_ADMIN = 'ILGIC MLCE Admin';
    case MARINE_EXT_TEAM_MEMBER = 'Marine EXT Team';
    case MARINE_MLCE_TEAM_MEMBER = 'Marine MLCE Team';
    case RM = 'RM';
    case VERTICAL_RM = 'Vertical RM';
    case CHANNEL_PARTNER = 'Channel Partner';
    case UW = 'U/W';
    case INSURED_ADMIN = 'Insured Admin';
    case INSURED_REPRESENTATIVE = 'Insured Representative';
    case GUEST = "Guest";
}
