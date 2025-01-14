<?php

namespace SmartDato\SfExpress\Enums\OrderExtendInfo;

enum IsSignBackEnum: string
{
    case NO = '0';
    case YES_SIGN_TO_ORIGIN = '1';
    case YES_SEND_TO_THIRD_PARTY = '2';
}
