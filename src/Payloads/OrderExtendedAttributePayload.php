<?php

namespace SmartDato\SfExpress\Payloads;

use SmartDato\SfExpress\Contracts\PayloadContract;

class OrderExtendedAttributePayload implements PayloadContract
{
    public function __construct(
        protected string $attributeName,
        protected string $attributeValue,
    ) {}

    public function build(): array
    {
        return [
            'attributeName' => $this->attributeName,
            'attributeValue' => $this->attributeValue,
        ];
    }
}
