<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class Role extends AbstractActiveRecord implements AllGetRequestsInterface
{

    use AllGetRequestsTrait;

    /** @var positive-int */
    public int $id;
    public string $name;
    /** Default: '0' */
    public bool $isSuper;

    /** @param array{
     *     "id": string,
     *     "name": string,
     *     "super": string,
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = ApiInt::fromStringOrNull($originalData['id'])->positiveInt;
        $this->name = ApiString::fromStringOrNull($originalData['name'])->string;
        $this->isSuper = ApiBool::fromStringOrNull($originalData['super'])->bool;
    }

    /** @return ApiModel::Role */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::Role;
    }

    public function __get(string $name): mixed
    {
        return match ($name) {
            default => $this->originalDto->$name
        };
    }
}
