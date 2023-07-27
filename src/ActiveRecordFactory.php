<?php
declare(strict_types=1);

namespace VetmanagerApiGateway;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\DTO\AbstractModelDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;

/**
 * @template TActiveRecord of AbstractActiveRecord
 * @template TModelDTO of AbstractModelDTO
 */
class ActiveRecordFactory
{
    public function __construct(
        public readonly ApiService $apiService,
        public readonly DtoFactory $dtoFactory
    )
    {
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public function getFromApiResponseWithSingleModelAsArray(array $apiResponseAsArray, string $activeRecordClass): AbstractActiveRecord
    {
        $modelKeyInResponse = $activeRecordClass::getModelKeyInResponseFromActiveRecordClass($activeRecordClass);
        $dtoClass = $activeRecordClass::getDtoClassFromActiveRecordClass($activeRecordClass);
        $dto = $this->dtoFactory->getFromApiResponseWithSingleModelAsArray(
            $apiResponseAsArray,
            $modelKeyInResponse,
            $dtoClass
        );
        return $this->getFromSingleDto($dto, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord[]
     * @throws VetmanagerApiGatewayException
     */
    public function getFromApiResponseWithMultipleModelsAsArray(array $apiResponseAsArray, string $activeRecordClass): array
    {
        $modelKeyInResponse = $activeRecordClass::getModelKeyInResponseFromActiveRecordClass($activeRecordClass);
        $dtoClass = $activeRecordClass::getDtoClassFromActiveRecordClass($activeRecordClass);
        $dtos = $this->dtoFactory->getFromApiResponseWithMultipleModelsArray(
            $apiResponseAsArray,
            $modelKeyInResponse,
            $dtoClass
        );
        return $this->getFromMultipleDtos($dtos, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord[]
     * @throws VetmanagerApiGatewayException
     */
    public function getFromMultipleModelsAsArray(array $modelsAsArray, string $activeRecordClass): array
    {
        return array_map(
            fn(array $modelAsArray): AbstractActiveRecord => $this->getFromSingleModelAsArray($modelAsArray, $activeRecordClass),
            $modelsAsArray
        );
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public function getFromSingleModelAsArray(array $modelAsArray, string $activeRecordClass): AbstractActiveRecord
    {
        $dtoClass = $activeRecordClass::getDtoClassFromActiveRecordClass($activeRecordClass);
        return $this->getFromSingleModelAsArrayAndDtoClass($modelAsArray, $activeRecordClass, $dtoClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @param class-string<TModelDTO> $dtoClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public function getFromSingleModelAsArrayAndDtoClass(
        array $modelAsArray, string $activeRecordClass, string $dtoClass
    ): AbstractActiveRecord
    {
        $dto = $this->dtoFactory->getFromSingleModelAsArray($modelAsArray, $dtoClass);
        return $this->getFromSingleDto($dto, $activeRecordClass);
    }

    /**
     * @param AbstractModelDTO[] $modelDTOs
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord[]
     */
    public function getFromMultipleDtos(array $modelDTOs, string $activeRecordClass): array
    {
        return array_map(
            fn(AbstractModelDTO $modelDTO): AbstractActiveRecord => $this->getFromSingleDto($modelDTO, $activeRecordClass),
            $modelDTOs
        );
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord
     */
    public function getFromSingleDto(AbstractModelDTO $modelDTO, string $activeRecordClass): AbstractActiveRecord
    {
        return new $activeRecordClass($this, $modelDTO);
    }

    /** Создание чистого нового Active Record для дальнейшей отправки на сервер
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getEmpty(string $activeRecordClass): AbstractActiveRecord
    {
        $dtoClass = $activeRecordClass::getDtoClassFromActiveRecordClass($activeRecordClass);
        $emptyDto = $this->dtoFactory->getEmpty($dtoClass);
        return new $activeRecordClass($this, $emptyDto);
    }
}