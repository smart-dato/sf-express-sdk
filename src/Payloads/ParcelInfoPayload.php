<?php

namespace SmartDato\SfExpress\Payloads;

class ParcelInfoPayload
{
    public function __construct(
        protected float $amount,
        protected string $name,
        protected string $eName,
        protected string $originCountry,
        protected float $quantity,
        protected string $unit,
        protected ?string $hsCode = null,
        protected ?string $brand = null,
        protected ?string $stateBarCode = null,
        protected ?string $productCustomsNumber = null,
        protected ?string $productRecordNumber = null,
        protected ?string $goodsCode = null,
        protected ?string $goodsUrl = null,
        protected ?float $weight = null,
        protected ?string $goodsDescription = null,
        protected ?string $material = null,
        protected ?string $specifications = null,
        protected ?string $itemNumber = null,
        protected ?float $quantityOne = null,
        protected ?string $unitOne = null,
        protected ?float $quantityTwo = null,
        protected ?string $unitTwo = null,
        protected ?string $htsCode = null,
        protected ?string $htsDescription = null,
        protected ?string $eccn = null,
        protected ?string $productNameElement = null,
        protected ?string $sellerVatNumber = null,
    ) {}

    public function build(): array
    {
        $payload = [
            'amount' => $this->amount,
            'name' => $this->name,
            'eName' => $this->eName,
            'originCountry' => $this->originCountry,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
        ];

        $optionalData = $this->getOptionalData();

        return [...$payload, ...$optionalData];
    }

    private function getOptionalData(): array
    {
        $data = [];

        $this->hsCode && $data['hsCode'] = $this->hsCode;
        $this->brand && $data['brand'] = $this->brand;
        $this->stateBarCode && $data['stateBarCode'] = $this->stateBarCode;
        $this->productCustomsNumber && $data['productCustomsNo'] = $this->productCustomsNumber;
        $this->productRecordNumber && $data['productRecordNo'] = $this->productRecordNumber;
        $this->goodsCode && $data['goodsCode'] = $this->goodsCode;
        $this->goodsUrl && $data['goodsUrl'] = $this->goodsUrl;
        $this->weight && $data['weight'] = $this->weight;
        $this->goodsDescription && $data['goodsDesc'] = $this->goodsDescription;
        $this->material && $data['material'] = $this->material;
        $this->specifications && $data['specifications'] = $this->specifications;
        $this->itemNumber && $data['itemNo'] = $this->itemNumber;
        $this->quantityOne && $data['qtyOne'] = $this->quantityOne;
        $this->unitOne && $data['unitOne'] = $this->unitOne;
        $this->quantityTwo && $data['qtyTwo'] = $this->quantityTwo;
        $this->unitTwo && $data['unitTwo'] = $this->unitTwo;
        $this->htsCode && $data['htsCode'] = $this->htsCode;
        $this->htsDescription && $data['htsDesc'] = $this->htsDescription;
        $this->eccn && $data['eccn'] = $this->eccn;
        $this->productNameElement && $data['productNameElement'] = $this->productNameElement;
        $this->sellerVatNumber && $data['sellerVatNumber'] = $this->sellerVatNumber;

        return $data;
    }
}
