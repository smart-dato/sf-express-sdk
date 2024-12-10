<?php

namespace SmartDato\SfExpress\Payloads;

use Exception;
use SmartDato\SfExpress\Contracts\PayloadContract;

class ShipmentDetailsPayload implements PayloadContract
{
    public function __construct(
        protected string $customerCode,
        protected ?string $version = null,
        protected ?string $sfWaybillNumber = null,
        protected ?string $customerOrderNumber = null,
    ) {}

    public function toJson(): string
    {
        return json_encode($this->build());
    }

    /**
     * @throws Exception
     */
    public function build(): array
    {
        if (empty($this->sfWaybillNumber) && empty($this->customerOrderNumber)) {
            throw new Exception('Either the SF waybill No. (parent waybill No.) or customer order No. shall be filled in.');
        }

        return [
            'customerCode' => $this->customerCode,
            'version' => $this->version,
            'sfWaybillNo' => $this->sfWaybillNumber,
            'customerOrderNo' => $this->customerOrderNumber,
        ];
    }
}
