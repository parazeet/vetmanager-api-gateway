<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class City extends AbstractFacade implements AllRequestsInterface
{
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\City\City::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\City\City
    {
        return $this->protectedGetById(self::getBasicActiveRecord(), $id);
    }
    /** @return ActiveRecord\City\City[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\City\City::class, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\City\City[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\City\City::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\City\City[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\City\City::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @return ActiveRecord\City\City[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\City\City::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\City\City
    {
        return $this->activeRecordFactory->getEmpty(ActiveRecord\City\City::class);
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\City\City
    {
        return $this->protectedCreateNewUsingArray(ActiveRecord\City\City::class, $modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\City\City
    {
        return $this->protectedUpdateUsingIdAndArray(ActiveRecord\City\City::class, $id, $modelAsArray);
    }
}