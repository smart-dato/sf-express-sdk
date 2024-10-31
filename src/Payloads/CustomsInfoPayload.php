<?php

namespace SmartDato\SfExpress\Payloads;

use SmartDato\SfExpress\Contracts\PayloadContract;
use SmartDato\SfExpress\Enums\CustomsInfo\SenderReasonEnum;

class CustomsInfoPayload implements PayloadContract
{
    public function __construct(
        protected ?string $tradeCondition = null,
        protected ?SenderReasonEnum $senderReason = null,
        protected ?string $senderReasonContent = null,
        protected ?string $businessRemark = null,
        protected ?string $customsBatch = null,
        protected ?string $importCustomsType = null,
        protected ?string $exportCustomsType = null,
        protected ?string $harmonizedCode = null,
        protected ?string $aesNumber = null,
    ) {}

    public function build(): array
    {
        return [
            'tradeCondition' => $this->tradeCondition,
            'senderReason' => $this->senderReason,
            'senderReasonContent' => $this->senderReasonContent,
            'businessRemark' => $this->businessRemark,
            'customsBatch' => $this->customsBatch,
            'importCustomsType' => $this->importCustomsType,
            'exportCustomsType' => $this->exportCustomsType,
            'harmonizedCode' => $this->harmonizedCode,
            'aesNo' => $this->aesNumber,
        ];
    }
}
