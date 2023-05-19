<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @psalm-suppress PropertyNotSetInConstructor, RedundantPropertyInitializationCheck - одобрено в доках PSALM для этого случая */
final class BreedDto extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    /** @var non-empty-string */
    public string $title;
    /** @var positive-int */
    public int $typeId;

    /** @param array{
     *       id: string,
     *       title: string,
     *       pet_type_id: string,
     *       petType?: array
     *   } $originalData
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalData): self
    {
        $instance = new self();
        $instance->id = ApiInt::fromStringOrNull($originalData['id'])->positiveInt;
        $instance->title = ApiString::fromStringOrNull($originalData['title'])->stringOrThrowIfNull;
        $instance->typeId = ApiInt::fromStringOrNull($originalData['pet_type_id'])->positiveInt;
        return $instance;
    }

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array
    {
        return ['title', 'pet_type_id'];
    }

    /** @inheritdoc */
    protected function getSetValuesWithoutId(): array
    {
        return array_merge(
            isset($this->title) ? ['title' => $this->title] : [],
            isset($this->typeId) ? ['pet_type_id' => (string)$this->typeId] : [],
        );
    }
}
