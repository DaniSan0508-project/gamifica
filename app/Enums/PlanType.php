<?php

namespace App\Enums;

enum PlanType: string
{
    case Free = 'free';
    case Pro = 'pro';
    case Enterprise = 'enterprise';
}
