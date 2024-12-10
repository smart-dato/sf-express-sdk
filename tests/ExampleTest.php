<?php

use SmartDato\SfExpress\Enums\Shipment\CurrencyEnum;
use SmartDato\SfExpress\Enums\Shipment\InterProductCodeEnum;
use SmartDato\SfExpress\Payloads\ParcelInfoPayload;
use SmartDato\SfExpress\Payloads\PaymentInfoPayload;
use SmartDato\SfExpress\Payloads\ShipmentDetailsPayload;
use SmartDato\SfExpress\Payloads\ShipmentPayload;
use SmartDato\SfExpress\Payloads\ShippingPartyPayload;
use SmartDato\SfExpress\Payloads\TrackingPayload;
use SmartDato\SfExpress\SfExpress;

it('can track a shipment', function () {
    $payload = new TrackingPayload(
        sfWaybillNumbers: ['SF00000000000000'],
        phoneNumber: '0000'
    );

    $data = (new SfExpress(
        baseUrl: 'https://api-ifsp-sit.sf.global',
        appKey: '',
        appSecret: '',
        encodingAesKey: '',
    ))->getTrackingStatus(
        $payload->toJson()
    );

    expect($data)->toBeArray()
        ->and($data['msg'])->toBe('success');
})->skip();

it('can create a shipment', function () {
    $payload = new ShipmentPayload(
        customerCode: 'ICRME00000',
        interProductCode: InterProductCodeEnum::INT0014,
        parcelQuantity: 1,
        customerOrderNumber: now()->timestamp,
        parcels: [
            new ParcelInfoPayload(
                amount: 0.1,
                name: 'Good',
                eName: 'Good',
                originCountry: 'DE',
                quantity: 1,
                unit: 'KG',
            ),
        ],
        paymentInfo: new PaymentInfoPayload(
            payMethod: '1',
            payMonthCard: '000000000',
            taxPayMethod: '2',
            taxPayMonthCard: '',
        ),
        receiverInfo: new ShippingPartyPayload(
            address: 'Werner-Heisenberg-Allee 25',
            regionSecond: '106A',
            contact: 'Uli Hoeneß',
            country: 'DE',
            postCode: '80939',
            regionFirst: 'München',
            phoneNumber: '1234567890',
            email: 'foo@nonowhere.com',
        ),
        senderInfo: new ShippingPartyPayload(
            address: 'Bismarckstraße 122-124',
            regionSecond: '11A',
            contact: 'Rudi Voller',
            country: 'DE',
            postCode: '51373',
            regionFirst: 'Leverkusen',
            phoneNumber: '0123456789',
        ),
        declaredValue: 0,
        declaredCurrency: CurrencyEnum::EUR,
        parcelTotalWeight: 0.1,
        parcelWeightUnit: 'kg',
        parcelTotalLength: 10,
        parcelTotalWidth: 5,
        parcelTotalHeight: 15
    );

    $data = (new SfExpress(
        baseUrl: 'https://api-ifsp-sit.sf.global',
        appKey: '',
        appSecret: '',
        encodingAesKey: '',
    ))->createShipment(
        $payload->toJson()
    );

    expect($data)->toBeArray()
        ->and($data['msg'])->toBe('Executed successfully');
})->skip();

it('can get shipment details', function () {
    $payload = new ShipmentDetailsPayload(
        customerCode: 'ICRME000SRN93',
        sfWaybillNumber: "SF1660016101717",
        customerOrderNumber: "kts_api20210701840182584",
    );

    $data = (new SfExpress(
        baseUrl: 'https://api-ifsp-sit.sf.global',
        appKey: '',
        appSecret: '',
        encodingAesKey: '',
    ))->getShipmentDetails(
        $payload->toJson()
    );

    expect($data)->toBeArray()
        ->and($data['msg'])->toBe('Executed successfully');
})->skip();
