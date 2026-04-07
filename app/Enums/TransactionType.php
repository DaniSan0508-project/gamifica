<?php

namespace App\Enums;

enum TransactionType: string
{
    case MissionComplete = 'mission_complete';
    case RewardRedeem = 'reward_redeem';
    case AdminAdjustment = 'admin_adjustment';
}
