<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use DateInterval;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DateIntervalContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class UserPosition extends AbstractActiveRecord implements AllGetRequestsInterface
{

    use AllGetRequestsTrait;

    public int $id;
    public string $title;
    /** Default: '00:30:00'. Type in DB: 'time'. Null if '00:00:00' */
    public ?DateInterval $admissionLength;

    /** @param array{
     *     "id": string,
     *     "title": string,
     *     "admission_length": string,
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->title = StringContainer::fromStringOrNull($originalData['title'])->string;
        $this->admissionLength = DateIntervalContainer::fromStringHMS($originalData['admission_length'])->dateIntervalOrNull;
    }

    /** @return ApiModel::UserPosition */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::UserPosition;
    }
}
