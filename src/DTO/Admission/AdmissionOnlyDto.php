<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Admission;

use DateInterval;
use DateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToBool;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateInterval;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

class AdmissionOnlyDto extends AbstractDTO implements AdmissionOnlyDtoInterface
{
    /**
     * @param string|null $id
     * @param string|null $admission_date Пример "2020-12-31 17:51:18". Может быть: "0000-00-00 00:00:00" - перевожу в null
     * @param string|null $description
     * @param string|null $client_id
     * @param string|null $patient_id
     * @param string|null $user_id
     * @param string|null $type_id
     * @param string|null $admission_length Примеры: "00:15:00", "00:00:00" (последнее перевожу в null)
     * @param string|null $status
     * @param string|null $clinic_id
     * @param string|null $direct_direction
     * @param string|null $creator_id
     * @param string|null $create_date Приходит: "2015-07-08 06:43:44", но бывает и "0000-00-00 00:00:00". Последнее переводится в null
     * @param string|null $escorter_id Кроме "0" другие значения искал - не нашел. Думаю передумали реализовывать
     * @param string|null $reception_write_channel
     * @param string|null $is_auto_create
     * @param string|null $invoices_sum Default: 0.0000000000
     */
    public function __construct(
        protected ?string $id,
        protected ?string $admission_date,
        protected ?string $description,
        protected ?string $client_id,
        protected ?string $patient_id,
        protected ?string $user_id,
        protected ?string $type_id,
        protected ?string $admission_length,
        protected ?string $status,
        protected ?string $clinic_id,
        protected ?string $direct_direction,
        protected ?string $creator_id,
        protected ?string $create_date,
        protected ?string $escorter_id,
        protected ?string $reception_write_channel,
        protected ?string $is_auto_create,
        protected ?string $invoices_sum,
    )
    {
    }

    public function getId(): int
    {
        return ToInt::fromStringOrNull($this->id)->getPositiveIntOrThrow();
    }

    public function getAdmissionDateAsDateTime(): DateTime
    {
        return ToDateTime::fromFullDateTimeString($this->admission_date)->getDateTimeOrThrow();
    }

    public function getDescription(): string
    {
        return ToString::fromStringOrNull($this->description)->getStringEvenIfNullGiven();
    }

    public function getClientId(): ?int
    {
        return ToInt::fromStringOrNull($this->client_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getPetId(): ?int
    {
        return ToInt::fromStringOrNull($this->patient_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getUserId(): ?int
    {
        return ToInt::fromStringOrNull($this->user_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getTypeId(): ?int
    {
        return ToInt::fromStringOrNull($this->type_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getAdmissionLengthAsDateInterval(): ?DateInterval
    {
        return ToDateInterval::fromStringHMS($this->admission_length)->getDateIntervalOrNull();
    }

    public function getStatusAsEnum(): ?StatusEnum
    {
        return $this->status ? StatusEnum::from($this->status) : null;
    }

    public function getClinicId(): ?int
    {
        return ToInt::fromStringOrNull($this->clinic_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getIsDirectDirection(): bool
    {
        return ToBool::fromStringOrNull($this->direct_direction)->getBoolOrThrowIfNull();
    }

    public function getCreatorId(): ?int
    {
        return ToInt::fromStringOrNull($this->creator_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getCreateDateAsDateTime(): DateTime
    {
        return ToDateTime::fromFullDateTimeString($this->create_date)->getDateTimeOrThrow();
    }

    public function getEscortId(): ?int
    {
        return ToInt::fromStringOrNull($this->escorter_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getReceptionWriteChannel(): string
    {
        return ToString::fromStringOrNull($this->reception_write_channel)->getStringOrThrowIfNull();
    }

    public function getIsAutoCreate(): bool
    {
        return ToBool::fromStringOrNull($this->is_auto_create)->getBoolOrThrowIfNull();
    }

    public function getInvoicesSum(): ?float
    {
        return ToFloat::fromStringOrNull($this->invoices_sum)->getNonZeroFloatOrNull();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionDateFromString(string $value): static
    {
        return self::setPropertyFluently($this, 'admission_date', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionDateFromDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'admission_date', $value->format('Y-m-d H:i:s'));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDescription(string $value): static
    {
        return self::setPropertyFluently($this, 'description', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setClientId(int $value): static
    {
        return self::setPropertyFluently($this, 'client_id', (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPatientId(int $value): static
    {
        return self::setPropertyFluently($this, 'patient_id', (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setUserId(int $value): static
    {
        return self::setPropertyFluently($this, 'user_id', (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTypeId(int $value): static
    {
        return self::setPropertyFluently($this, 'type_id', (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionLengthFromString(string $value): static
    {
        return self::setPropertyFluently($this, 'admission_length', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionLengthFromDateInterval(DateInterval $value): static
    {
        return self::setPropertyFluently($this, 'admission_length', $value->format('H:i:s'));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatusFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'status', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatusFromEnum(StatusEnum $value): static
    {
        return self::setPropertyFluently($this, 'status', $value->value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setClinicId(int $value): static
    {
        return self::setPropertyFluently($this, 'clinic_id', (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsDirectDirection(bool $value): static
    {
        return self::setPropertyFluently($this, 'direct_direction', $value ? "1" : "0");
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreatorId(int $value): static
    {
        return self::setPropertyFluently($this, 'creator_id', (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreateDateFromString(string $value): static
    {
        return self::setPropertyFluently($this, 'create_date', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreateDateFromDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'create_date', $value->format('Y-m-d H:i:s'));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setEscortId(int $value): static
    {
        return self::setPropertyFluently($this, 'escorter_id', (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setReceptionWriteChannel(string $value): static
    {
        return self::setPropertyFluently($this, 'reception_write_channel', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsAutoCreate(bool $value): static
    {
        return self::setPropertyFluently($this, 'is_auto_create', $value ? "1" : "0");
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setInvoicesSum(?float $value): static
    {
        return self::setPropertyFluently($this, 'invoices_sum', is_null($value) ? null : (string)$value);
    }

//    /** @param array{
//     *          id: numeric-string,
//     *          admission_date: string,
//     *          description: string,
//     *          client_id: numeric-string,
//     *          patient_id: numeric-string,
//     *          user_id: numeric-string,
//     *          type_id: numeric-string,
//     *          admission_length: string,
//     *          status: ?string,
//     *          clinic_id: numeric-string,
//     *          direct_direction: string,
//     *          creator_id: numeric-string,
//     *          create_date: string,
//     *          escorter_id: ?numeric-string,
//     *          reception_write_channel: ?string,
//     *          is_auto_create: string,
//     *          invoices_sum: string,
//     *          client: array,
//     *          pet?: array,
//     *          wait_time?: string,
//     *          invoices?: array,
//     *          doctor_data?: array,
//     *          admission_type_data?: array
//     *     } $originalDataArray
//     */
}