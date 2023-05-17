<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\ComboManualNameDto;
use VetmanagerApiGateway\DTO\Enum\ComboManualName\Name;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @property-read ComboManualNameDto $originalDto
 * @property positive-int id
 * @property non-empty-string title
 * @property bool isReadonly
 * @property non-empty-string name
 * @property array{
 *       id: string,
 *       title: string,
 *       is_readonly: string,
 *       name: string,
 *       comboManualItems: list<array{
 *                                    id: string,
 *                                    combo_manual_id: string,
 *                                    title: string,
 *                                    value: string,
 *                                    dop_param1: string,
 *                                    dop_param2: string,
 *                                    dop_param3: string,
 *                                    is_active: string
 *                                   }
 *                             >
 *   } $originalDataArray 'comboManualItems' массив только при GetById
 * @property-read comboManualItem[] comboManualItems
 */
final class ComboManualName extends AbstractActiveRecord implements AllGetRequestsInterface
{
    use AllGetRequestsTrait;

    /** @return ApiModel::ComboManualName */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::ComboManualName;
    }

    /**
     * @throws VetmanagerApiGatewayException - родительское исключение
     * @throws VetmanagerApiGatewayRequestException|VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException
     */
    public static function getByName(ApiGateway $apiGateway, string $comboManualName): self
    {
        $comboManualNames = self::getByQueryBuilder($apiGateway, (new Builder())->where("name", $comboManualName), 1);
        return $comboManualNames[0];
    }

    /**
     * @param string $comboManualName Вместо строки можно пользоваться методом, принимающий Enum {@see getIdByNameAsEnum}
     * @throws VetmanagerApiGatewayException - родительское исключение
     * @throws VetmanagerApiGatewayRequestException|VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException
     */
    public static function getIdByNameAsString(ApiGateway $apiGateway, string $comboManualName): int
    {
        return self::getByName($apiGateway, $comboManualName)->id;
    }

    /**
     * @param Name $comboManualName Не нравится пользоваться Enum или не хватает значения - другой метод {@see getIdByNameAsString}
     * @throws VetmanagerApiGatewayException - родительское исключение
     * @throws VetmanagerApiGatewayRequestException|VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException
     */
    public static function getIdByNameAsEnum(ApiGateway $apiGateway, Name $comboManualName): int
    {
        return self::getIdByNameAsString($apiGateway, $comboManualName->value);
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'comboManualItems' => ComboManualItem::fromMultipleDtosArrays(
                $this->apiGateway,
                $this->originalDataArray['comboManualItems']
            ),
            default => $this->originalDto->$name
        };
    }
}
