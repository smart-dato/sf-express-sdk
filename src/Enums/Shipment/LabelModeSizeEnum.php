<?php

namespace SmartDato\SfExpress\Enums\Shipment;

enum LabelModeSizeEnum: int
{
    case STYLE_0 = 0; // waybill 100*210; invoice A4
    case STYLE_1 = 1; // waybill 100*150; invoice100*150
    case STYLE_2 = 2; // waybill 100*45 (BBD consolidated parcel barcode)
    case STYLE_3 = 3; // waybill 100*150(order pick up label)
    case STYLE_4 = 4; // waybill 100*210(order pick up label)
    case STYLE_5 = 5; // waybill 100*45
    case STYLE_7 = 7; // waybill 100*45 (BBD consolidated parcel QR code)
    case STYLE_8 = 8; // waybill 100*45 (BBD pre-consolidated large parcel barcode)
}
