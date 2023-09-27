<?php

namespace App\Entity;

use App\Entity\Base\BaseEntity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScheduleFormRepository")
 * @ORM\Table(name="schedule_form")
 * @ORM\HasLifecycleCallbacks()
 */

class ScheduleFormEntity extends BaseEntity
{
    /**
     * @ORM\Column(type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="schedule_form_id", type="string", nullable=true)
     */
    protected $scheduleFormId;

    /**
     * @ORM\Column(name="field_id", type="string", nullable=true)
     */
    protected $fieldId;
    

    /**
     * @ORM\Column(name="form_name", type="string", nullable=true)
     */
    protected $formName;

    /**
     * @ORM\Column(name="field_value", type="string", nullable=true)
     */
    protected $fieldValue;


    /**
     * @ORM\Column(name="field_name", type="string", nullable=true)
     */
    protected $fieldName;

    /**
     * @ORM\ManyToOne(targetEntity="ScheduleEntity", inversedBy="scheduleForms")
     * @ORM\JoinColumn(name="schedule_id", referencedColumnName="id")
     */
    protected $schedule;
   
    public function __construct($data = null)
    {

    }

    /*--------------------------------------------------------------------------------------------------------*/
    /*					User Defined Setters and Getters													  */
    /*--------------------------------------------------------------------------------------------------------*/


      /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return ScheduleFormEntity
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function setCreatedBy(?string $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function setUpdatedBy(?string $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /*--------------------------------------------------------------------------------------------------------*/
    /*					    Defined Setters and Getters													      */
    /*--------------------------------------------------------------------------------------------------------*/

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getScheduleFormId(): ?string
    {
        return $this->scheduleFormId;
    }

    public function setScheduleFormId(?string $scheduleFormId): self
    {
        $this->scheduleFormId = $scheduleFormId;

        return $this;
    }

    public function getFieldId(): ?string
    {
        return $this->fieldId;
    }

    public function setFieldId(?string $fieldId): self
    {
        $this->fieldId = $fieldId;

        return $this;
    }

    public function getFormName(): ?string
    {
        return $this->formName;
    }

    public function setFormName(?string $formName): self
    {
        $this->formName = $formName;

        return $this;
    }

    public function getFieldValue(): ?string
    {
        return $this->fieldValue;
    }

    public function setFieldValue(?string $fieldValue): self
    {
        $this->fieldValue = $fieldValue;

        return $this;
    }

    public function getFieldName(): ?string
    {
        return $this->fieldName;
    }

    public function setFieldName(?string $fieldName): self
    {
        $this->fieldName = $fieldName;

        return $this;
    }

    public function getSchedule(): ?ScheduleEntity
    {
        return $this->schedule;
    }

    public function setSchedule(?ScheduleEntity $schedule): self
    {
        $this->schedule = $schedule;

        return $this;
    }

    
}
