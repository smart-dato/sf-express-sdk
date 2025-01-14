<?php

namespace SmartDato\SfExpress\Payloads;

use SmartDato\SfExpress\Contracts\PayloadContract;
use SmartDato\SfExpress\Enums\OrderExtendInfo\BusinessMode;
use SmartDato\SfExpress\Enums\OrderExtendInfo\IsSelfPickEnum;
use SmartDato\SfExpress\Enums\OrderExtendInfo\IsSignBackEnum;

class OrderExtendInfoPayload implements PayloadContract
{
    public function __construct(
        protected ?IsSignBackEnum $isSignBack = null,
        protected ?IsSelfPickEnum $isSelfPick = null,
        protected ?string $signBackWaybillNumber = null,

        protected ?BusinessMode $businessMode = null,
        protected ?string $senderDeptCode = null,
        protected ?string $operEmpCode = null,

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
        return array_filter([
            'isSignBack' => $this->isSignBack,
            'isSelfPick' => $this->isSelfPick,
            'signBackWaybillNo' => $this->signBackWaybillNumber,
            'businessMode' => $this->businessMode?->value,
            'senderDeptCode' => $this->senderDeptCode,
            'operEmpCode' => $this->operEmpCode,

            'preMergeSfWaybillNo' => $this->preMergeSfWaybillNumber,

            'poNumber' => $this->poNumber,
            'importerCompanyName' => $this->importerCompanyName,
            'importerPhoneCode' => $this->importerPhoneCode,
            'importerPhoneNumber' => $this->importerPhoneNumber,
            'importerAddress' => $this->importerAddress,
            'importCompTaxNo' => $this->importerCompanyTaxNumber,
            'importCompContacts' => $this->importerCompanyContacts,
            'importCompEmail' => $this->importerCompanyEmail,
        ], function ($value) {
            return ! is_null($value);
        });
    }
}
