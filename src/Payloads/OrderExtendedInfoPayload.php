<?php

namespace SmartDato\SfExpress\Payloads;

use SmartDato\SfExpress\Contracts\PayloadContract;
use SmartDato\SfExpress\Enums\OrderExtendedInfo\IsSelfPickEnum;
use SmartDato\SfExpress\Enums\OrderExtendedInfo\IsSignBackEnum;

class OrderExtendedInfoPayload implements PayloadContract
{
    public function __construct(
        protected ?IsSignBackEnum $isSignBack = null,
        protected ?IsSelfPickEnum $isSelfPick = null,
        protected ?string $signBackWaybillNumber = null,
        protected ?string $preMergeSfWaybillNumber = null,
        protected ?string $poNumber = null,
        protected ?string $importerCompanyName = null,
        protected ?string $importerPhoneCode = null,
        protected ?string $importerPhoneNumber = null,
        protected ?string $importerAddress = null,
        protected ?string $importerCompanyTaxNumber = null,
        protected ?string $importerCompanyContacts = null,
        protected ?string $importerCompanyEmail = null,
    ) {}

    public function build(): array
    {
        return [
            'isSignBack' => $this->isSignBack,
            'isSelfPick' => $this->isSelfPick,
            'signBackWaybillNo' => $this->signBackWaybillNumber,
            'preMergeSfWaybillNo' => $this->preMergeSfWaybillNumber,
            'poNumber' => $this->poNumber,
            'importerCompanyName' => $this->importerCompanyName,
            'importerPhoneCode' => $this->importerPhoneCode,
            'importerPhoneNumber' => $this->importerPhoneNumber,
            'importerAddress' => $this->importerAddress,
            'importCompTaxNo' => $this->importerCompanyTaxNumber,
            'importCompContacts' => $this->importerCompanyContacts,
            'importCompEmail' => $this->importerCompanyEmail,
        ];
    }
}
