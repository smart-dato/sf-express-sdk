<?php

namespace SmartDato\SfExpress\Payloads;

use JsonException;
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

    /**
     * @throws JsonException
     */
    public function toJson(): string
    {
        return json_encode($this->build(), JSON_THROW_ON_ERROR);
    }

    public function build(): array
    {
        return [
            'sfWaybillNoList' => $this->sfWaybillNumbers,
            'phoneNo' => $this->phoneNumber,
        ];
    }
}
