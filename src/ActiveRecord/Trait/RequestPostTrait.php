<?php

namespace VetmanagerApiGateway\ActiveRecord\Trait;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

trait RequestPostTrait
{
    /**
     * @inheritDoc
     * @throws VetmanagerApiGatewayException
     */
    public function createAsNew(): self
    {
        return self::createAsNewUsingArray(
            $this->apiGateway,
            $this->apiGateway->post(
                self::getApiModel(),
                $this->userMadeDto->getAsArrayForPostRequest()
            )
        );
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function createAsNewUsingArray(ApiGateway $apiGateway, array $data): self
    {
        return new self(
            $apiGateway,
            $apiGateway->post(self::getApiModel(), $data)
        );
    }
}
