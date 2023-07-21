<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use VetmanagerApiGateway\DTO\Enum\Client\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

class ClientDto extends AbstractModelDTO
{
    /**
     * @param string|null $email Default: ''
     * @param string|null $date_register В БД бывает дефолтное значение: '0000-00-00 00:00:00'
     * @param string|null $status Default: Active
     * @param string|null $street_id Default: 0
     * @param string|null $apartment Default: ''
     * @param string|null $unsubscribe Default: 0
     * @param string|null $in_blacklist Default: 0
     * @param string|null $last_visit_date В БД бывает дефолтное значение: '0000-00-00 00:00:00'
     * @param string|null $number_of_journal Default: ''
     */
    public function __construct(
        protected ?string $id,
        protected ?string $address,
        protected ?string $home_phone,
        protected ?string $work_phone,
        protected ?string $note,
        protected ?string $type_id,
        protected ?string $how_find,
        protected ?string $balance,
        protected ?string $email,
        protected ?string $city,
        protected ?string $city_id,
        protected ?string $date_register,
        protected ?string $cell_phone,
        protected ?string $zip,
        protected ?string $registration_index,
        protected ?string $vip,
        protected ?string $last_name,
        protected ?string $first_name,
        protected ?string $middle_name,
        protected ?string $status,
        protected ?string $discount,
        protected ?string $passport_series,
        protected ?string $lab_number,
        protected ?string $street_id,
        protected ?string $apartment,
        protected ?string $unsubscribe,
        protected ?string $in_blacklist,
        protected ?string $last_visit_date,
        protected ?string $number_of_journal,
        protected ?string $phone_prefix
    )
    {
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int
    {
        return ApiInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(int $id): self
    {
        return self::setPropertyFluently($this, 'id', (string)$id);
    }

    public function getAddress(): string
    {
        return ApiString::fromStringOrNull($this->address)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAddress(string $address): self
    {
        return self::setPropertyFluently($this, 'address', $address);
    }

    public function getHomePhone(): string
    {
        return ApiString::fromStringOrNull($this->home_phone)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setHomePhone(string $home_phone): self
    {
        return self::setPropertyFluently($this, 'home_phone', $home_phone);
    }

    public function getWorkPhone(): string
    {
        return ApiString::fromStringOrNull($this->work_phone)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setWorkPhone(string $work_phone): self
    {
        return self::setPropertyFluently($this, 'work_phone', $work_phone);
    }

    public function getNote(): string
    {
        return ApiString::fromStringOrNull($this->note)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setNote(string $note): self
    {
        return self::setPropertyFluently($this, 'note', $note);
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getTypeId(): ?int
    {
        return ApiInt::fromStringOrNull($this->type_id)->getPositiveIntOrNull();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTypeId(string $type_id): self
    {
        return self::setPropertyFluently($this, 'type_id', $type_id);
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getHowFind(): ?int
    {
        return ApiInt::fromStringOrNull($this->how_find)->getPositiveIntOrNull();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setHowFind(string $how_find): self
    {
        return self::setPropertyFluently($this, 'how_find', $how_find);
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getBalance(): float
    {
        return ApiFloat::fromStringOrNull($this->balance)->getFloatOrThrow();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setBalance(string $balance): self
    {
        return self::setPropertyFluently($this, 'balance', $balance);
    }

    public function getEmail(): string
    {
        return ApiString::fromStringOrNull($this->email)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setEmail(string $email): self
    {
        return self::setPropertyFluently($this, 'email', $email);
    }

    public function getCityTitle(): string
    {
        return ApiString::fromStringOrNull($this->city)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCityTitle(string $city): self
    {
        return self::setPropertyFluently($this, 'city', $city);
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCityId(): ?int
    {
        return ApiInt::fromStringOrNull($this->city_id)->getPositiveIntOrNull();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCityId(string $city_id): self
    {
        return self::setPropertyFluently($this, 'city_id', $city_id);
    }

    /** Пустые значения переводятся в null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getDateRegister(): ?DateTime
    {
        return ApiDateTime::fromFullDateTimeString($this->date_register)->getDateTimeOrThrow();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDateRegister(string $date_register): self
    {
        return self::setPropertyFluently($this, 'date_register', $date_register);
    }

    public function getCellPhone(): string
    {
        return ApiString::fromStringOrNull($this->cell_phone)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCellPhone(string $cell_phone): self
    {
        return self::setPropertyFluently($this, 'cell_phone', $cell_phone);
    }

    public function getZip(): string
    {
        return ApiString::fromStringOrNull($this->zip)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setZip(string $zip): self
    {
        return self::setPropertyFluently($this, 'zip', $zip);
    }

    public function getRegistrationIndex(): string
    {
        return ApiString::fromStringOrNull($this->registration_index)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setRegistrationIndex(string $registrationIndex): self
    {
        return self::setPropertyFluently($this, 'registration_index', $registrationIndex);
    }

    /** Default: 0
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsVip(): bool
    {
        return ApiBool::fromStringOrNull($this->vip)->getBoolOrThrowIfNull();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsVip(string $vip): self
    {
        return self::setPropertyFluently($this, 'vip', $vip);
    }

    public function getLastName(): string
    {
        return ApiString::fromStringOrNull($this->last_name)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setLastName(string $last_name): self
    {
        return self::setPropertyFluently($this, 'last_name', $last_name);
    }

    public function getFirstName(): string
    {
        return ApiString::fromStringOrNull($this->first_name)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setFirstName(string $first_name): self
    {
        return self::setPropertyFluently($this, 'first_name', $first_name);
    }

    public function getMiddleName(): string
    {
        return ApiString::fromStringOrNull($this->middle_name)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setMiddleName(string $middle_name): self
    {
        return self::setPropertyFluently($this, 'middle_name', $middle_name);
    }

    public function getStatus(): Status
    {
        return Status::from($this->status);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatus(Status $status): self
    {
        return self::setPropertyFluently($this, 'status', $status->value);
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getDiscount(): int
    {
        return ApiInt::fromStringOrNull($this->discount)->getIntEvenIfNullGiven();
    }


    /** @throws VetmanagerApiGatewayInnerException */
    public function setDiscount(int $discount): self
    {
        return self::setPropertyFluently($this, 'discount', (string)$discount);
    }

    public function getPassportSeries(): string
    {
        return ApiString::fromStringOrNull($this->passport_series)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPassportSeries(string $passport_series): self
    {
        return self::setPropertyFluently($this, 'passport_series', $passport_series);
    }

    public function getLabNumber(): string
    {
        return ApiString::fromStringOrNull($this->lab_number)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setLabNumber(string $lab_number): self
    {
        return self::setPropertyFluently($this, 'lab_number', $lab_number);
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getStreetId(): ?int
    {
        return ApiInt::fromStringOrNull($this->street_id)->getPositiveIntOrNull();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStreetId(?int $streetId): self
    {
        return self::setPropertyFluently(
            $this,
            'streetId',
            is_null($streetId) ? null : (string)$streetId
        );
    }

    public function getApartment(): string
    {
        return ApiString::fromStringOrNull($this->apartment)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setApartment(string $apartment): self
    {
        return self::setPropertyFluently($this, 'apartment', $apartment);
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getIsUnsubscribed(): bool
    {
        return ApiBool::fromStringOrNull($this->unsubscribe)->getBoolOrThrowIfNull();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setUnsubscribe(?bool $isUnsubscribed): self
    {
        return self::setPropertyFluently(
            $this,
            'unsubscribe',
            is_null($isUnsubscribed) ? "0" : (string)(int)$isUnsubscribed
        );
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getIsBlacklisted(): bool
    {
        return ApiBool::fromStringOrNull($this->in_blacklist)->getBoolOrThrowIfNull();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setInBlacklist(?bool $in_blacklist): self
    {
        return self::setPropertyFluently(
            $this,
            'in_blacklist',
            is_null($in_blacklist) ? "0" : (string)(int)$in_blacklist
        );
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getLastVisitDate(): ?DateTime
    {
        return ApiDateTime::fromFullDateTimeString($this->last_visit_date)->getDateTimeOrThrow();
    }

    /** @throws VetmanagerApiGatewayResponseException
     * @throws VetmanagerApiGatewayException
     */
    public function setLastVisitDateFromSting(?string $last_visit_date): self
    {
        $value = is_null($last_visit_date)
            ? "0000-00-00 00:00:00"
            : ApiDateTime::fromFullDateTimeString($last_visit_date)->getAsDataBaseStringOrThrowIfNull();
        return self::setPropertyFluently(
            $this,
            'last_visit_date',
            $value
        );
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setLastVisitDateFromDateTime(DateTime $last_visit_date): self
    {
        return self::setPropertyFluently($this, 'last_visit_date', $last_visit_date->format('Y-m-d H:i:s'));
    }

    public function getNumberOfJournal(): string
    {
        return ApiString::fromStringOrNull($this->number_of_journal)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setNumberOfJournal(string $number_of_journal): self
    {
        return self::setPropertyFluently($this, 'number_of_journal', $number_of_journal);
    }

    public function getPhonePrefix(): string
    {
        return ApiString::fromStringOrNull($this->phone_prefix)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPhonePrefix(string $phone_prefix): self
    {
        return self::setPropertyFluently($this, 'phone_prefix', $phone_prefix);
    }
}
