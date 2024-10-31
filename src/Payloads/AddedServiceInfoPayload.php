<?php

namespace SmartDato\SfExpress\Payloads;

use SmartDato\SfExpress\Contracts\PayloadContract;
use SmartDato\SfExpress\Enums\AddedServiceInfo\ServiceCodeEnum;

class AddedServiceInfoPayload implements PayloadContract
{
    public function __construct(
        protected ?ServiceCodeEnum $serviceCode = null,
        protected ?string $value = null,
        protected ?string $valueOne = null,
    ) {}

    public function build(): array
    {
        return [
            'serviceCode' => $this->serviceCode,
            'value' => $this->value,
            'valueOne' => $this->valueOne,
        ];
    }
}
