<?php

namespace SmartDato\SfExpress\Enums\OrderExtendInfo;

enum BusinessMode: string
{
    case GENERAL_ORDER = '0';
    case CONFIRM_WEIGHT = '1';
    case RECONFIRM_WEIGHT = '2';
}
