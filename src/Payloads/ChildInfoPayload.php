<?php

namespace SmartDato\SfExpress\Payloads;

use SmartDato\SfExpress\Contracts\PayloadContract;

class ChildInfoPayload implements PayloadContract
{
    public function __construct(
        protected ?string $sfWaybillNumber = null,
        protected ?float $weight = null,
        protected ?float $length = null,
        protected ?float $width = null,
        protected ?float $height = null,
        protected ?string $boxNumber = null,
    ) {}

    public function build(): array
    {
        return [
            'sfWaybillNo' => $this->sfWaybillNumber,
            'weight' => $this->weight,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'boxNo' => $this->boxNumber,
        ];
    }
}
