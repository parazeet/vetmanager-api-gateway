<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\DO\FloatContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\DTO\Enum\GoodSaleParam\PriceFormation;
use VetmanagerApiGateway\DTO\Enum\GoodSaleParam\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class GoodSaleParamDto extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    /** @var ?positive-int Default: 0 */
    public ?int $goodId;
    public ?float $price;
    /** Default: 1 */
    public float $coefficient;
    /** @var ?positive-int Default: 0 */
    public ?int $unitSaleId;
    public ?float $minPriceInPercents;
    public ?float $maxPriceInPercents;
    public string $barcode;
    /** Default: 'active' */
    public Status $status;
    /** @var ?positive-int Default: 0 */
    public ?int $clinicId;
    public ?float $markup;
    /** Default: 'fixed' */
    public PriceFormation $priceFormation;


    /** @param array{
     *     "id": string,
     *     "good_id": string,
     *     "price": ?string,
     *     "coefficient": string,
     *     "unit_sale_id": string,
     *     "min_price": ?string,
     *     "max_price": ?string,
     *     "barcode": ?string,
     *     "status": string,
     *     "clinic_id": string,
     *     "markup": string,
     *     "price_formation": ?string,
     *     "unitSale"?: array,
     *     "good"?: array,
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(array $originalData)
    {
        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->goodId = IntContainer::fromStringOrNull($originalData['good_id'])->positiveIntOrNull;
        $this->price = FloatContainer::fromStringOrNull($originalData['price'])->floatOrNull;
        $this->coefficient = FloatContainer::fromStringOrNull($originalData['coefficient'])->float;
        $this->unitSaleId = IntContainer::fromStringOrNull($originalData['unit_sale_id'])->positiveIntOrNull;
        $this->minPriceInPercents = FloatContainer::fromStringOrNull($originalData['min_price'])->floatOrNull;
        $this->maxPriceInPercents = FloatContainer::fromStringOrNull($originalData['max_price'])->floatOrNull;
        $this->barcode = StringContainer::fromStringOrNull($originalData['barcode'])->string;
        $this->status = Status::from($originalData['status']);
        $this->clinicId = IntContainer::fromStringOrNull($originalData['clinic_id'])->positiveIntOrNull;
        $this->markup = FloatContainer::fromStringOrNull($originalData['markup'])->floatOrNull;
        $this->priceFormation = PriceFormation::from((string)$originalData['price_formation']);
    }
}
