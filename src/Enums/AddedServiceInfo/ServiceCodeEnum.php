<?php

namespace SmartDato\SfExpress\Enums\AddedServiceInfo;

enum ServiceCodeEnum: string
{
    /* International Shipping */
    case COD = 'COD'; // COD (Cash on delivery)
    case SPP = 'SPP'; // SPP (Shipment Protection Plus)
    case IN162 = 'IN162'; // Delivery Confirmation Signature Required

    /* Domestic Shipping */
    case INKEX2 = 'INKEX2'; // Service Protection Plus
    case INKEX3 = 'INKEX3'; // Cash On Delivery
    case INKEX48 = 'INKEX48'; // Pick up
    case INKEX43 = 'INKEX43'; // Return POD
}
