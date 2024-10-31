<?php

namespace SmartDato\SfExpress\Payloads;

use SmartDato\SfExpress\Contracts\PayloadContract;
use SmartDato\SfExpress\Enums\ShippingParty\CargoTypeEnum;
use SmartDato\SfExpress\Enums\ShippingParty\CertificateTypeEnum;

class ShippingPartyPayload implements PayloadContract
{
    public function __construct(
        protected string $address,
        protected string $regionSecond,
        protected string $contact,
        protected string $country,
        protected string $postCode,
        protected string $regionFirst,
        protected string $phoneNumber,
        protected ?string $email = null,
        protected ?string $company = null,
        protected ?string $regionThird = null,
        protected ?string $regionFifth = null,
        protected ?string $regionSixth = null,
        protected ?string $telAreaCode = null,
        protected ?string $telNumber = null,
        protected ?string $phoneAreaCode = null,
        protected ?CargoTypeEnum $cargoType = null,
        protected ?CertificateTypeEnum $certificateType = null,
        protected ?string $certificateCardNumber = null,
        protected ?string $vat = null,
        protected ?string $eori = null,
        protected ?string $iossNumber = null,
        protected ?string $lvgNumber = null,
        protected ?string $contactI18n = null,
        protected ?string $addressI18n = null,
    ) {}

    public function build(): array
    {
        $payload = [
            'address' => $this->address,
            'regionSecond' => $this->regionSecond,
            'contact' => $this->contact,
            'country' => $this->country,
            'postCode' => $this->postCode,
            'regionFirst' => $this->regionFirst,
            'phoneNo' => $this->phoneNumber,
        ];

        if (! empty($this->email)) {
            $payload['email'] = $this->email;
        }

        if (! empty($this->company)) {
            $payload['company'] = $this->company;
        }

        if (! empty($this->regionThird)) {
            $payload['regionThird'] = $this->regionThird;
        }

        if (! empty($this->regionFifth)) {
            $payload['regionFifth'] = $this->regionFifth;
        }

        if (! empty($this->regionSixth)) {
            $payload['regionSixth'] = $this->regionSixth;
        }

        if (! empty($this->telAreaCode)) {
            $payload['telAreaCode'] = $this->telAreaCode;
        }

        if (! empty($this->telNumber)) {
            $payload['telNo'] = $this->telNumber;
        }

        if (! empty($this->phoneAreaCode)) {
            $payload['phoneAreaCode'] = $this->phoneAreaCode;
        }

        if (! empty($this->cargoType)) {
            $payload['cargoType'] = $this->cargoType;
        }

        if (! empty($this->certificateType)) {
            $payload['certType'] = $this->certificateType;
        }

        if (! empty($this->certificateCardNumber)) {
            $payload['certCardNo'] = $this->certificateCardNumber;
        }

        if (! empty($this->vat)) {
            $payload['vat'] = $this->vat;
        }

        if (! empty($this->eori)) {
            $payload['eori'] = $this->eori;
        }

        if (! empty($this->iossNumber)) {
            $payload['iossNo'] = $this->iossNumber;
        }

        if (! empty($this->lvgNumber)) {
            $payload['lvgNo'] = $this->lvgNumber;
        }

        if (! empty($this->contactI18n)) {
            $payload['contactI18n'] = $this->contactI18n;
        }

        if (! empty($this->addressI18n)) {
            $payload['addressI18n'] = $this->addressI18n;
        }

        return $payload;
    }
}
