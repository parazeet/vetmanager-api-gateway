<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class Good extends AbstractActiveRecord implements AllGetRequestsInterface
{

    use AllGetRequestsTrait;

    /** Предзагружен. Нового АПИ запроса не будет */
    public ActiveRecord\GoodGroup $group;
    /** Предзагружен. Нового АПИ запроса не будет */
    public ?ActiveRecord\Unit $unit;
    /** @var GoodSaleParam[] Предзагружены. Нового АПИ запроса не будет */
    public array $goodSaleParams;

    /** @param array{
     *     "id": string,
     *     "group_id": ?string,
     *     "title": string,
     *     "unit_storage_id": ?string,
     *     "is_warehouse_account": string,
     *     "is_active": string,
     *     "code": ?string,
     *     "is_call": string,
     *     "is_for_sale": string,
     *     "barcode": ?string,
     *     "create_date": string,
     *     "description": string,
     *     "prime_cost": string,
     *     "category_id": ?string,
     *     "group": array{
     *              "id": string,
     *              "title": string,
     *              "is_service": string,
     *              "markup": ?string,
     *              "is_show_in_vaccines": string,
     *              "price_id": ?string
     *     },
     *     "unitStorage"?: array{
     *              "id": string,
     *              "title": string,
     *              "status": string
     *     },
     *     "goodSaleParams": array<int, array{
     *              "id": string,
     *              "good_id": string,
     *              "price": ?string,
     *              "coefficient": string,
     *              "unit_sale_id": string,
     *              "min_price": ?string,
     *              "max_price": ?string,
     *              "barcode": ?string,
     *              "status": string,
     *              "clinic_id": string,
     *              "markup": string,
     *              "price_formation": ?string,
     *              "unitSale"?: array{
     *                      "id": string,
     *                      "title": string,
     *                      "status": string,
     *              }
     *     }>
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->group = GoodGroup::fromSingleDtoArray($this->apiGateway, $originalData['group']);

        $this->unit = !empty($originalData['unitStorage'])
            ? Unit::fromSingleDtoArray($this->apiGateway, $originalData['unitStorage'])
            : null;

        $this->goodSaleParams = GoodSaleParam::fromMultipleDtosArrays(
            $this->apiGateway,
            $this->getContentsForGoodSaleParamActiveRecords()
        );
    }

    private function getContentsForGoodSaleParamActiveRecords(): array
    {
        return array_map(
            fn (array $goodSaleParamObject): array => array_merge(
                $goodSaleParamObject,
                !empty($this->originalDataArray['unitStorage']) ? ['unitSale' => $this->originalDataArray['unitStorage']] : [],
                ['good' => $this->getOnlyGoodContentsArray()]
            ),
            $this->originalDataArray['goodSaleParams']
        );
    }

    /** @return array<string, ?string> */
    private function getOnlyGoodContentsArray(): array
    {
        $originalData = $this->originalDataArray;
        unset($originalData['group'], $originalData['unitStorage'], $originalData['goodSaleParams']);
        return $originalData;
    }

    public static function getApiModel(): ApiModel
    {
        return ApiModel::Good;
    }

    public function __get(string $name): mixed
    {
        return match ($name) {
            default => $this->originalDto->$name
        };
    }
}
