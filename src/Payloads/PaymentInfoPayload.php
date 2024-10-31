<?php

namespace SmartDato\SfExpress\Payloads;

use SmartDato\SfExpress\Contracts\PayloadContract;

class PaymentInfoPayload implements PayloadContract
{
    public function __construct(
        protected string $payMethod,
        protected string $payMonthCard,
        protected string $taxPayMethod,
        protected string $taxPayMonthCard,
    ) {}

    public function build(): array
    {
        return [
            'payMethod' => $this->payMethod,
            'payMonthCard' => $this->payMonthCard,
            'taxPayMethod' => $this->taxPayMethod,
            'taxPayMonthCard' => $this->taxPayMonthCard,
        ];
    }
}
