<?php

namespace SmartDato\SfExpress\Payloads;

use SmartDato\SfExpress\Contracts\PayloadContract;

class OrderEcommerceInfoPayload implements PayloadContract
{
    public function __construct(
        protected ?string $payerCertificateType = null,
        protected ?string $payerCertificateNumber = null,
        protected ?string $payerName = null,
        protected ?string $payerTel = null,
        protected ?string $buyerEmail = null,
        protected ?string $buyerNickname = null,
        protected ?float $buyerFreight = null,
        protected ?float $buyerPremium = null,
        protected ?string $tax = null,
        protected ?float $preferentialAmount = null,
        protected ?float $actualPay = null,
        protected ?string $currency = null,
        protected ?string $payToolType = null,
        protected ?string $applicationNumber = null,
        protected ?string $payNumber = null,
        protected ?string $platformDomainName = null,
        protected ?string $payTime = null,
        protected ?string $promotionType = null,
        protected ?string $sellerEmail = null,
        protected ?string $sellerNickname = null,
        protected ?string $sellerAlipayNumber = null,
        protected ?string $payEnterpriseCustomsCode = null,
        protected ?string $payEnterpriseCheckCode = null,
        protected ?string $payEnterpriseName = null,
        protected ?string $storeCode = null,
        protected ?string $shopWebCode = null,
        protected ?string $enterpriseName = null,
        protected ?string $enterpriseCustomsCode = null,
        protected ?string $enterpriseCheckCode = null,
        protected ?string $enterpriseCrossCode = null,
        protected ?string $platformName = null,
        protected ?string $platformCustomsCode = null,
        protected ?string $platformCheckCode = null,
        protected ?string $partZoneCode = null,
        protected ?string $portCode = null,
        protected ?string $importCustomsType = null,
    ) {}

    public function build(): array
    {
        return [
            'payerCertType' => $this->payerCertificateType,
            'payerCertNo' => $this->payerCertificateNumber,
            'payerName' => $this->payerName,
            'payerTel' => $this->payerTel,
            'buyerEmail' => $this->buyerEmail,
            'buyerNickname' => $this->buyerNickname,
            'buyerFreight' => $this->buyerFreight,
            'buyerPremium' => $this->buyerPremium,
            'tax' => $this->tax,
            'preferentialAmount' => $this->preferentialAmount,
            'actPay' => $this->actualPay,
            'currency' => $this->currency,
            'payToolType' => $this->payToolType,
            'applicationNo' => $this->applicationNumber,
            'payNo' => $this->payNumber,
            'platformDomainName' => $this->platformDomainName,
            'payTime' => $this->payTime,
            'promotionType' => $this->promotionType,
            'sellerEmail' => $this->sellerEmail,
            'sellerNickname' => $this->sellerNickname,
            'sellerAlipayNo' => $this->sellerAlipayNumber,
            'payEnterpriseCustomsCode' => $this->payEnterpriseCustomsCode,
            'payEnterpriseCheckCode' => $this->payEnterpriseCheckCode,
            'payEnterpriseName' => $this->payEnterpriseName,
            'storeCode' => $this->storeCode,
            'shopWebCode' => $this->shopWebCode,
            'enterpriseName' => $this->enterpriseName,
            'enterpriseCustomsCode' => $this->enterpriseCustomsCode,
            'enterpriseCheckCode' => $this->enterpriseCheckCode,
            'enterpriseCrossCode' => $this->enterpriseCrossCode,
            'platformName' => $this->platformName,
            'platformCustomsCode' => $this->platformCustomsCode,
            'platformCheckCode' => $this->platformCheckCode,
            'partZoneCode' => $this->partZoneCode,
            'portCode' => $this->portCode,
            'importCustomsType' => $this->importCustomsType,
        ];
    }
}
