<?php

namespace SmartDato\SfExpress\Payloads;

use JsonException;
use SmartDato\SfExpress\Contracts\PayloadContract;
use SmartDato\SfExpress\Exceptions\NoWaybillNumberException;

class ShipmentDetailsPayload implements PayloadContract
{
    public function __construct(
        protected string $customerCode,
        protected ?string $version = null,
        protected ?string $sfWaybillNumber = null,
        protected ?string $customerOrderNumber = null,
    ) {}

    /**
     * @throws JsonException
     * @throws NoWaybillNumberException
     */
    public function toJson(): string
    {
        return json_encode($this->build(), JSON_THROW_ON_ERROR);
    }

    /**
     * @throws NoWaybillNumberException
     */
    public function build(): array
    {
        if (empty($this->sfWaybillNumber) && empty($this->customerOrderNumber)) {
            $message = 'Either the SF waybill No. (parent waybill No.) or customer order No. shall be filled in.';
            throw new NoWaybillNumberException($message);
        }

        return [
            'customerCode' => $this->customerCode,
            'version' => $this->version,
            'sfWaybillNo' => $this->sfWaybillNumber,
            'customerOrderNo' => $this->customerOrderNumber,
        ];
    }
}
