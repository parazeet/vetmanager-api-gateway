<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/** @psalm-suppress PropertyNotSetInConstructor, RedundantPropertyInitializationCheck - одобрено в доках PSALM для этого случая */
class CityTypeDto extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    public string $title;

    /** @param array{
     *     "id": string,
     *     "title": string,
     * } $originalData
     * @psalm-suppress MoreSpecificImplementedParamType
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromApiResponseArray(array $originalData): self
    {
        $instance = new self();
        $instance->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $instance->title = StringContainer::fromStringOrNull($originalData['title'])->string;
        return $instance;
    }

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array
    {
        return ['title'];
    }

    /** @inheritdoc */
    protected function getSetValuesWithoutId(): array
    {
        return array_merge(
            isset($this->title) ? ['title' => $this->title] : [],
        );
    }
}
