<?php

namespace SmartDato\SfExpress\Enums\ShippingParty;

enum CertificateTypeEnum: string
{
    case ID_CARD = '001';
    case PASSPORT = '002';
    case MILITARY_ID = '003';
    case POLICE_CERTIFICATE = '004';
    case HONG_KONG_PERMIT = '005';
    case TAIWAN_PERMIT = '006';
    case SOCIAL_CREDIT_CODE = '007';
    case CR_CODE = '008';
    case UNIFORM_NUMBER = '009';
    case UEN = '010';
    case CORPORATE_NUMBER = '011';
    case IMPORTER_NUMBER = '012';
    case TAX_ACCOUNT = '013';
    case SSN = '014';
    case EORI = '015';
    case CLEARANCE = '016';
    case COMPANY_CLEARANCE = '017';
    case BUSINESS_REGISTRATION = '018';
    case AADHAAR = '019';
    case PAN = '020';
    case IEC = '021';
    case GST = '022';
    case RESIDENT_CERTIFICATE = '023';
    case VAT = '025';
    case INDONESIA_ID = '029';
    case INDONESIA_DRIVING_LICENSE = '031';
    case KITAS = '032';
    case KITAP = '033';
    case NPWP = '034';
    case OTHERS = '100';
    case TAX_ID = '5';
}
