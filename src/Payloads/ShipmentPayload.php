<?php

namespace SmartDato\SfExpress\Payloads;

use SmartDato\SfExpress\Contracts\PayloadContract;
use SmartDato\SfExpress\Enums\Shipment\CurrencyEnum;
use SmartDato\SfExpress\Enums\Shipment\InterProductCodeEnum;
use SmartDato\SfExpress\Enums\Shipment\LabelModeSizeEnum;
use SmartDato\SfExpress\Enums\Shipment\LengthUnitEnum;
use SmartDato\SfExpress\Enums\Shipment\OrderOperateTypeEnum;
use SmartDato\SfExpress\Enums\Shipment\PickupTypeEnum;

class ShipmentPayload implements PayloadContract
{
    /**
     * @param  ParcelInfoPayload[]  $parcels
     * @param  AddedServiceInfoPayload[]|null  $addedServices
     * @param  ChildInfoPayload[]|null  $children
     * @param  OrderExtendedAttributePayload[]|null  $extendedAttributes
     */
    public function __construct(
        protected string $customerCode,
        protected InterProductCodeEnum $interProductCode,
        protected int $parcelQuantity,
        protected string $customerOrderNumber,
        protected array $parcels,
        protected PaymentInfoPayload $paymentInfo,
        protected ShippingPartyPayload $receiverInfo,
        protected ShippingPartyPayload $senderInfo,
        protected float $declaredValue,
        protected CurrencyEnum $declaredCurrency,
        protected ?string $version = null,
        protected ?OrderOperateTypeEnum $orderOperateType = OrderOperateTypeEnum::ADD,
        protected ?string $customerOrderNumberTwo = null,
        protected ?string $sfWaybillNumber = null,
        protected ?float $parcelTotalWeight = null,
        protected ?string $parcelWeightUnit = null,
        protected ?float $parcelTotalLength = null,
        protected ?float $parcelTotalWidth = null,
        protected ?float $parcelTotalHeight = null,
        protected ?LengthUnitEnum $parcelVolumeUnit = LengthUnitEnum::CM,
        protected ?PickupTypeEnum $pickupType = null,
        protected ?string $pickupAppointTime = null,
        protected ?string $pickupAppointTimeZone = null,
        protected ?string $remark = null,
        protected ?bool $isBbd = null,
        protected ?OrderExtendedInfoPayload $orderExtendedInfo = null,
        protected ?CustomsInfoPayload $customsInfo = null,
        protected ?array $addedServices = null,
        protected ?array $children = null,
        protected ?array $extendedAttributes = null,
        protected ?OrderEcommerceInfoPayload $ecommerceInfo = null,
        protected ?string $agentWaybillNumber = null,
        protected ?LabelModeSizeEnum $labelModeSize = LabelModeSizeEnum::STYLE_1,
        protected ?bool $isReturnRouteLabel = null,
    ) {}

    public function toJson(): string
    {
        return json_encode($this->build());
    }

    public function build(): array
    {
        $payload = [
            'addServiceInfoList' => [],
            'customerCode' => $this->customerCode,
            'customerOrderNo' => $this->customerOrderNumber,
            'declaredCurrency' => $this->declaredCurrency,
            'declaredValue' => $this->declaredValue,
            'interProductCode' => $this->interProductCode,
            'parcelInfoList' => array_map(
                fn (ParcelInfoPayload $parcel) => $parcel->build(),
                $this->parcels
            ),
            'parcelQuantity' => $this->parcelQuantity,
            'paymentInfo' => $this->paymentInfo->build(),
            'receiverInfo' => $this->receiverInfo->build(),
            'senderInfo' => $this->senderInfo->build(),
        ];

        $optionalData = $this->getOptionalData();

        return [...$payload, ...$optionalData];
    }

    private function getOptionalData(): array
    {
        $data = [];

        $this->version && $data['version'] = $this->version;
        $this->orderOperateType && $data['orderOperateType'] = $this->orderOperateType;
        $this->customerOrderNumberTwo && $data['customerOrderNoTwo'] = $this->customerOrderNumberTwo;
        $this->sfWaybillNumber && $data['sfWaybillNo'] = $this->sfWaybillNumber;
        $this->parcelTotalWeight && $data['parcelTotalWeight'] = $this->parcelTotalWeight;
        $this->parcelWeightUnit && $data['parcelWeightUnit'] = $this->parcelWeightUnit;
        $this->parcelTotalLength && $data['parcelTotalLength'] = $this->parcelTotalLength;
        $this->parcelTotalWidth && $data['parcelTotalWidth'] = $this->parcelTotalWidth;
        $this->parcelTotalHeight && $data['parcelTotalHeight'] = $this->parcelTotalHeight;
        $this->parcelVolumeUnit && $data['parcelVolumeUnit'] = $this->parcelVolumeUnit;
        $this->pickupType && $data['pickupType'] = $this->pickupType;
        $this->pickupAppointTime && $data['pickupAppointTime'] = $this->pickupAppointTime;
        $this->pickupAppointTimeZone && $data['pickupAppointTimeZone'] = $this->pickupAppointTimeZone;
        $this->remark && $data['remark'] = $this->remark;
        $this->isBbd && $data['isBbd'] = strval($this->isBbd);
        $this->orderExtendedInfo && $data['orderExtendedInfo'] = $this->orderExtendedInfo->build();
        $this->customsInfo && $data['customsInfo'] = $this->customsInfo->build();
        $this->addedServices && $data['addServiceInfoList'] = array_map(
            fn (AddedServiceInfoPayload $addedService) => $addedService->build(),
            $this->addedServices
        );
        $this->children && $data['childInfoList'] = array_map(
            fn (ChildInfoPayload $childInfo) => $childInfo->build(),
            $this->children
        );
        $this->extendedAttributes && $data['extendAttributeList'] = array_map(
            fn (OrderExtendedAttributePayload $extendAttribute) => $extendAttribute->build(),
            $this->extendedAttributes
        );
        $this->ecommerceInfo && $data['ecommerceInfo'] = $this->ecommerceInfo->build();
        $this->agentWaybillNumber && $data['agentWaybillNo'] = $this->agentWaybillNumber;
        $this->labelModeSize && $data['labelModeSize'] = $this->labelModeSize;
        $this->isReturnRouteLabel && $data['isReturnRouteLabel'] = intval($this->isReturnRouteLabel);

        return $data;
    }
}
