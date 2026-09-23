# SF Express SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/smart-dato/sf-express-sdk.svg?style=flat-square)](https://packagist.org/packages/smart-dato/sf-express-sdk)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/smart-dato/sf-express-sdk/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/smart-dato/sf-express-sdk/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/smart-dato/sf-express-sdk/code-style.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/smart-dato/sf-express-sdk/actions?query=workflow%3A%22Code+style%22+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/smart-dato/sf-express-sdk.svg?style=flat-square)](https://packagist.org/packages/smart-dato/sf-express-sdk)

A Laravel package for the SF Express international open API. It creates shipments, queries order details and fetches tracking, handling the API's AES message encryption and request signing for you.

## Requirements

- PHP 8.2+
- Laravel 10 – 13
- The `openssl` PHP extension

## Installation

```bash
composer require smart-dato/sf-express-sdk
```

Publish the config file:

```bash
php artisan vendor:publish --tag="sf-express-sdk-config"
```

```dotenv
SF_EXPRESS_BASE_URL=https://api-ifsp-sit.sf.global
SF_EXPRESS_API_KEY=your-app-key
SF_EXPRESS_SECRET=your-app-secret
SF_EXPRESS_ENCODING_AES_KEY=your-encoding-aes-key
```

`https://api-ifsp-sit.sf.global` is SF's SIT (sandbox) environment.

## Usage

The `SfExpress` facade uses the configured credentials:

```php
use SmartDato\SfExpress\Facades\SfExpress;

$tracking = SfExpress::getTrackingStatus($payload->toJson());
```

Or construct the client yourself; any argument you leave out falls back to the config:

```php
use SmartDato\SfExpress\SfExpress;

$sf = new SfExpress(
    baseUrl: 'https://api-ifsp-sit.sf.global',
    appKey: 'your-app-key',
    appSecret: 'your-app-secret',
    encodingAesKey: 'your-encoding-aes-key',
);
```

The client fetches its access token from `/openapi/api/token` on the first API call, not when it is constructed. `SfExpressGenericException` is thrown if SF rejects the credentials.

Every method takes the request as a **JSON string**. The payload classes build that string for you with `toJson()`.

### Create a shipment

Sends an `IUOP_CREATE_ORDER` message.

```php
use SmartDato\SfExpress\Enums\Shipment\CurrencyEnum;
use SmartDato\SfExpress\Enums\Shipment\InterProductCodeEnum;
use SmartDato\SfExpress\Payloads\ParcelInfoPayload;
use SmartDato\SfExpress\Payloads\PaymentInfoPayload;
use SmartDato\SfExpress\Payloads\ShipmentPayload;
use SmartDato\SfExpress\Payloads\ShippingPartyPayload;

$payload = new ShipmentPayload(
    customerCode: 'your-customer-code',
    interProductCode: InterProductCodeEnum::INT0014,
    parcelQuantity: 1,
    customerOrderNumber: 'order-1001',
    parcels: [
        new ParcelInfoPayload(
            amount: 25.0,
            name: 'Gloves',
            eName: 'Gloves',
            originCountry: 'CN',
            quantity: 1,
            unit: 'your-unit',
        ),
    ],
    paymentInfo: new PaymentInfoPayload(
        payMethod: 'your-pay-method',
        payMonthCard: 'your-monthly-account',
        taxPayMethod: 'your-tax-pay-method',
        taxPayMonthCard: '',
    ),
    receiverInfo: new ShippingPartyPayload(
        address: 'Werner-Heisenberg-Allee 25',
        regionSecond: '106A',
        contact: 'Jane Doe',
        country: 'DE',
        postCode: '80939',
        regionFirst: 'München',
        phoneNumber: '+49 89 000000',
        email: 'jane@example.com',
    ),
    senderInfo: new ShippingPartyPayload(
        address: 'Bismarckstraße 122',
        regionSecond: '11A',
        contact: 'Sender GmbH',
        country: 'DE',
        postCode: '51373',
        regionFirst: 'Leverkusen',
        phoneNumber: '+49 214 000000',
    ),
    declaredValue: 25.0,
    declaredCurrency: CurrencyEnum::EUR,
    parcelTotalWeight: 0.4,
    parcelWeightUnit: 'kg',
    parcelTotalLength: 30,
    parcelTotalWidth: 20,
    parcelTotalHeight: 5,
);

$result = $sf->createShipment($payload->toJson());
```

`ShipmentPayload` also accepts pickup, customs, extended-info and added-service details — see its constructor for the full list.

### Query shipment details

Sends an `IUOP_QUERY_ORDER` message.

```php
use SmartDato\SfExpress\Payloads\ShipmentDetailsPayload;

$details = $sf->getShipmentDetails(
    (new ShipmentDetailsPayload(customerCode: 'your-customer-code', sfWaybillNumber: 'SF0000000000000'))->toJson()
);
```

### Track a shipment

Sends a `GTS_QUERY_TRACK` message.

```php
use SmartDato\SfExpress\Payloads\TrackingPayload;

$tracking = $sf->getTrackingStatus(
    (new TrackingPayload(sfWaybillNumbers: ['SF0000000000000'], phoneNumber: '0000'))->toJson()
);
```

Each method returns the decrypted response decoded into an array. A non-zero `apiResultCode` from SF raises `SfExpressGenericException` with the code and message.

## Testing

```bash
composer test
```

The tests that call SF's sandbox are skipped by default, since they need real credentials.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [SmartDato](https://github.com/smart-dato)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
