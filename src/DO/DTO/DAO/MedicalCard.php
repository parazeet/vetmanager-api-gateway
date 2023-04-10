<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO\DAO;

use DateTime;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DateTimeContainer;
use VetmanagerApiGateway\DO\DTO;
use VetmanagerApiGateway\DO\DTO\AbstractDTO;
use VetmanagerApiGateway\DO\DTO\DAO;
use VetmanagerApiGateway\DO\DTO\DAO\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\DO\Enum\MedicalCard\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read ?DAO\Clinic clinic
 * @property-read ?DAO\AdmissionFromGetById admission
 * @property-read ?DAO\AdmissionFromGetById nextMeet
 * @property-read ?DAO\ComboManualItem admissionType
 * @property-read ?DAO\ComboManualItem meetResult
 * @property-read ?DAO\Invoice invoice
 * @property-read ?DAO\User user
 */
class MedicalCard extends AbstractDTO implements AllGetRequestsInterface
{
    use BasicDAOTrait;
    use AllGetRequestsTrait;

    public int $id;
    public DateTime $dateCreate;
    public DateTime $dateEdit;
    /** Сюда приходит либо "0", либо JSON типа: "[ {"id":32,"type":1}, {"id":35,"type":1}, {"id":77,"type":1} ]" */
    public string $diagnose;
    public string $recommendation;
    /** Invoice ID (таблица invoice) */
    public ?int $invoice;
    /** Тип приема. Здесь
     * LEFT JOIN combo_manual_items ci ON ci.combo_manual_id = {$reasonId} AND ci.value = m.admission_type
     */
    public ?int $admissionType;
    public ?float $weight;
    public ?float $temperature;
    /** Default: 0    LEFT JOIN combo_manual_items ci2 ON ci2.combo_manual_id = 2 AND ci2.value = m.meet_result_id */
    public int $meetResultId;
    /** Может быть просто строка, а может HTML-блок */
    public string $description;
    /** Default: 0    LEFT JOIN admission ad ON ad.id = m.next_meet_id   */
    public int $nextMeetId;
    /** Default: 0 */
    public int $userId;
    /** Default: 0 */
    public int $creatorId;
    /** Default: 'active' */
    public Status $status;
    /** Default: 0
     * Вроде это ID из модуля задач. Пока непонятно */
    public int $callingId;
    /** Default: 0 */
    public int $admissionId;
    /** Пример: "Анемия;\nАнорексия, кахексия;\nАтопия" */
    public string $diagnoseText;
    /** Пример: "Анемия (Окончательные);\nАнорексия, кахексия (Окончательные);\nАтопия (Окончательные)" */
    public ?string $diagnoseTypeText;
    /** Default: 0 */
    public int $clinicId;
    public DTO\Pet $pet;

    /** @var array{
     *     "id": string,
     *     "patient_id": string,
     *     "date_create": string,
     *     "date_edit": ?string,
     *     "diagnos": string,
     *     "recomendation": string,
     *     "invoice": ?string,
     *     "admission_type": ?string,
     *     "weight": ?string,
     *     "temperature": ?string,
     *     "meet_result_id": string,
     *     "description": string,
     *     "next_meet_id": string,
     *     "doctor_id": string,
     *     "creator_id": string,
     *     "status": string,
     *     "calling_id": string,
     *     "admission_id": string,
     *     "diagnos_text": ?string,
     *     "diagnos_type_text": ?string,
     *     "clinic_id": string,
     *     "patient": array{
     *          "id": string,
     *          "owner_id": ?string,
     *          "type_id": ?string,
     *          "alias": string,
     *          "sex": ?string,
     *          "date_register": string,
     *          "birthday": ?string,
     *          "note": string,
     *          "breed_id": ?string,
     *          "old_id": ?string,
     *          "color_id": ?string,
     *          "deathnote": ?string,
     *          "deathdate": ?string,
     *          "chip_number": string,
     *          "lab_number": string,
     *          "status": string,
     *          "picture": ?string,
     *          "weight": ?string,
     *          "edit_date": string,
     *          }
     *      } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->diagnose = $this->originalData['diagnos'] ? (string)$this->originalData['diagnos'] : null;
        $this->recommendation = (string)$this->originalData['recomendation'];
        $this->admissionType = $this->originalData['admission_type'] ? (int)$this->originalData['admission_type'] : null;
        $this->weight = $this->originalData['weight'] ? (float)$this->originalData['weight'] : null;
        $this->temperature = $this->originalData['temperature'] ? (float)$this->originalData['temperature'] : null;
        $this->meetResultId = (int)$this->originalData['meet_result_id'];
        $this->userId = (int)$this->originalData['doctor_id'];
        $this->id = (int)$this->originalData['id'];
        $this->dateCreate = (DateTimeContainer::fromOnlyDateString($this->originalData['date_create']))->dateTime;
        $this->dateEdit = (DateTimeContainer::fromOnlyDateString($this->originalData['date_edit']))->dateTime;
        $this->invoice = $this->originalData['invoice'] ? (int)$this->originalData['invoice'] : null;
        $this->description = (string)$this->originalData['description'];
        $this->nextMeetId = (int)$this->originalData['next_meet_id'];
        $this->creatorId = (int)$this->originalData['creator_id'];    #TODO get?
        $this->status = Status::from($this->originalData['status']);
        $this->callingId = (int)$this->originalData['calling_id'];
        $this->admissionId = (int)$this->originalData['admission_id'];
        $this->diagnoseText = (string)$this->originalData['diagnos_text'];
        $this->diagnoseTypeText = $this->originalData['diagnos_type_text'] ? (string)$this->originalData['diagnos_type_text'] : null;
        $this->clinicId = (int)$this->originalData['clinic_id'];
        $this->pet = DTO\Pet::fromSingleObjectContents($this->apiGateway, $this->originalData['patient']);
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::MedicalCard;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'clinic' => $this->clinicId ? Clinic::getById($this->apiGateway, $this->clinicId) : null,
            'admission' => $this->admissionId ? AdmissionFromGetById::getById($this->apiGateway, $this->admissionId) : null,
            'nextMeet' => $this->nextMeetId ? AdmissionFromGetById::getById($this->apiGateway, $this->nextMeetId) : null,
            'admissionType' => $this->admissionType ? ComboManualItem::getByAdmissionTypeId($this->apiGateway, $this->admissionType) : null,
            'meetResult' => $this->meetResultId ? ComboManualItem::getByAdmissionResultId($this->apiGateway, $this->meetResultId) : null,
            'invoice' => $this->invoice ? Invoice::getById($this->apiGateway, $this->invoice) : null,
            'user' => $this->userId ? User::getById($this->apiGateway, $this->userId) : null,
            default => $this->$name,
        };
    }
}
