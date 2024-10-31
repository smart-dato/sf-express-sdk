<?php

namespace SmartDato\SfExpress\Payloads;

use SmartDato\SfExpress\Contracts\PayloadContract;

class TrackingPayload implements PayloadContract
{
    /**
     * @param  string[]  $sfWaybillNumbers
     */
    public function __construct(
        protected array $sfWaybillNumbers,
        protected string $phoneNumber,
    ) {}

    public function toJson(): string
    {
        return json_encode($this->build());
    }

    public function build(): array
    {
        return [
            'sfWaybillNoList' => $this->sfWaybillNumbers,
            'phoneNo' => $this->phoneNumber,
        ];
    }
}
