<?php

namespace SmartDato\SfExpress\Enums\Shipment;

enum PickupTypeEnum: string
{
    case SELF_DROP_OFF = '0';
    case DOOR_TO_DOOR = '1';
}
