<?php

namespace App\Entity;

use App\Entity\Base\BaseEntity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScheduleRepository")
 * @ORM\Table(name="schedule")
 * @ORM\HasLifecycleCallbacks()
 */

class ScheduleEntity extends BaseEntity
{
    /**
     * @ORM\Column(type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="acuity_id", type="string", nullable=true)
     */
    protected $acuityId;

    /**
     * @ORM\Column(name="schedule_date", type="string", nullable=true)
     */
    protected $scheduleDate;
    
    /**
     * @ORM\Column(name="start_time", type="string", nullable=true)
     */
    protected $startTime;

    /**
     * @ORM\Column(name="end_time", type="string", nullable=true)
     */
    protected $endTime;

    /**
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    protected $dateCreated;
        
    /**
     * @ORM\Column(name="price", type="string", nullable=true)
     */
    protected $price;

    /**
     * @ORM\Column(name="isPaid", type="boolean", nullable=true)
     */
    protected $isPaid;

    /**
     * @ORM\Column(name="schedule_type", type="string", nullable=true)
     */
    protected $scheduleType;

    /**
     * @ORM\Column(name="calendar", type="string", nullable=true)
     */
    protected $calendar;
    
    /**
     * @ORM\Column(name="calendar_time_zone", type="string", nullable=true)
     */
    protected $calendarTimeZone;

    /**
     * @ORM\Column(name="acuity_time_zone", type="string", nullable=true)
     */
    protected $acuityTimeZone;
    
    /**
     * @ORM\Column(name="confirmation_page", type="string", nullable=true)
     */
    protected $confirmationPage;
    
    /**
     * @ORM\Column(name="category", type="string", nullable=true)
     */
    protected $category;

    /**
     * @ORM\Column(name="confirmation_page_payment_link", type="string", nullable=true)
     */
    protected $confirmationPagePaymentLink;

        /**
     * @ORM\Column(name="file_desc", type="string", nullable=true)
     */
    protected $fileDesc;
    
     /**
     * @ORM\Column(name="parsed_file_desc", type="string", nullable=true)
     */
    protected $parsedFileDesc;


    /**
     * @ORM\ManyToOne(targetEntity="UserEntity", inversedBy="schedules")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

     /**
     * @ORM\OneToMany(targetEntity="ScheduleFormEntity", mappedBy="schedule", cascade={"remove"})
     */
    protected $scheduleForms;

    /**
     * @ORM\OneToMany(targetEntity="SchedulePaymentEntity", mappedBy="schedule", cascade={"remove"})
     */
    protected $schedulePayments;

    /**
     * @ORM\OneToMany(targetEntity="StoryEntity", mappedBy="schedule", cascade={"remove"})
     */
    protected $stories;

   
    public function __construct($data = null)
    {
        $this->scheduleForms = new ArrayCollection();
        $this->schedulePayments = new ArrayCollection();
        $this->stories = new ArrayCollection();
    }

    /*--------------------------------------------------------------------------------------------------------*/
    /*					User Defined Setters and Getters													  */
    /*--------------------------------------------------------------------------------------------------------*/


      /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return ScheduleEntity
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }


                /**
     * Remove the file from the disk
     *
     * @ORM\PreRemove
     */
    public function removeFile() {

        $file = $this->getUploadRootDir() . '/' . $this->parsedFileDesc;
        if(!empty($this->fileDesc) && file_exists($file)) unlink($file);
    }

    /**
     * Get uploadDir
     *
     * @return string
     */
    public function getUploadDir() {

        return '/uploads/audio';
    }

    /**
     * Get uploadRootDir
     *
     * @return string
     */
    public function getUploadRootDir() {

        return __DIR__ . './../../public' . $this->getUploadDir();
    }


    /**
     * get fileWebPath
     *
     * @return string
     */
    public function getFileWebPath() {

        $parsedDesc = $this->parsedFileDesc;
        $file = $this->getUploadRootDir() . '/' . $parsedDesc;
     
        if(!empty($parsedDesc) ) {
            return   $this->getUploadDir() . '/' . $parsedDesc;
        } else {
            return '';
        }
    }

    /*--------------------------------------------------------------------------------------------------------*/
    /*					    Defined Setters and Getters													      */
    /*--------------------------------------------------------------------------------------------------------*/

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getAcuityId(): ?string
    {
        return $this->acuityId;
    }

    public function setAcuityId(?string $acuityId): self
    {
        $this->acuityId = $acuityId;

        return $this;
    }

    public function getScheduleDate(): ?string
    {
        return $this->scheduleDate;
    }

    public function setScheduleDate(?string $scheduleDate): self
    {
        $this->scheduleDate = $scheduleDate;

        return $this;
    }

    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    public function setStartTime(?string $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?string
    {
        return $this->endTime;
    }

    public function setEndTime(?string $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function isIsPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(?bool $isPaid): self
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    public function getScheduleType(): ?string
    {
        return $this->scheduleType;
    }

    public function setScheduleType(?string $scheduleType): self
    {
        $this->scheduleType = $scheduleType;

        return $this;
    }

    public function getCalendar(): ?string
    {
        return $this->calendar;
    }

    public function setCalendar(?string $calendar): self
    {
        $this->calendar = $calendar;

        return $this;
    }

    public function getCalendarTimeZone(): ?string
    {
        return $this->calendarTimeZone;
    }

    public function setCalendarTimeZone(?string $calendarTimeZone): self
    {
        $this->calendarTimeZone = $calendarTimeZone;

        return $this;
    }

    public function getAcuityTimeZone(): ?string
    {
        return $this->acuityTimeZone;
    }

    public function setAcuityTimeZone(?string $acuityTimeZone): self
    {
        $this->acuityTimeZone = $acuityTimeZone;

        return $this;
    }

    public function getConfirmationPage(): ?string
    {
        return $this->confirmationPage;
    }

    public function setConfirmationPage(?string $confirmationPage): self
    {
        $this->confirmationPage = $confirmationPage;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getConfirmationPagePaymentLink(): ?string
    {
        return $this->confirmationPagePaymentLink;
    }

    public function setConfirmationPagePaymentLink(?string $confirmationPagePaymentLink): self
    {
        $this->confirmationPagePaymentLink = $confirmationPagePaymentLink;

        return $this;
    }

    public function getUser(): ?UserEntity
    {
        return $this->user;
    }

    public function setUser(?UserEntity $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, ScheduleFormEntity>
     */
    public function getScheduleForms(): Collection
    {
        return $this->scheduleForms;
    }

    public function addScheduleForm(ScheduleFormEntity $scheduleForm): self
    {
        if (!$this->scheduleForms->contains($scheduleForm)) {
            $this->scheduleForms[] = $scheduleForm;
            $scheduleForm->setSchedule($this);
        }

        return $this;
    }

    public function removeScheduleForm(ScheduleFormEntity $scheduleForm): self
    {
        if ($this->scheduleForms->removeElement($scheduleForm)) {
            // set the owning side to null (unless already changed)
            if ($scheduleForm->getSchedule() === $this) {
                $scheduleForm->setSchedule(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SchedulePaymentEntity>
     */
    public function getSchedulePayments(): Collection
    {
        return $this->schedulePayments;
    }

    public function addSchedulePayment(SchedulePaymentEntity $schedulePayment): self
    {
        if (!$this->schedulePayments->contains($schedulePayment)) {
            $this->schedulePayments[] = $schedulePayment;
            $schedulePayment->setSchedule($this);
        }

        return $this;
    }

    public function removeSchedulePayment(SchedulePaymentEntity $schedulePayment): self
    {
        if ($this->schedulePayments->removeElement($schedulePayment)) {
            // set the owning side to null (unless already changed)
            if ($schedulePayment->getSchedule() === $this) {
                $schedulePayment->setSchedule(null);
            }
        }

        return $this;
    }

    public function getFileDesc(): ?string
    {
        return $this->fileDesc;
    }

    public function setFileDesc(?string $fileDesc): self
    {
        $this->fileDesc = $fileDesc;

        return $this;
    }

    public function getParsedFileDesc(): ?string
    {
        return $this->parsedFileDesc;
    }

    public function setParsedFileDesc(?string $parsedFileDesc): self
    {
        $this->parsedFileDesc = $parsedFileDesc;

        return $this;
    }

    /**
     * @return Collection<int, StoryEntity>
     */
    public function getStories(): Collection
    {
        return $this->stories;
    }

    public function addStory(StoryEntity $story): self
    {
        if (!$this->stories->contains($story)) {
            $this->stories[] = $story;
            $story->setSchedule($this);
        }

        return $this;
    }

    public function removeStory(StoryEntity $story): self
    {
        if ($this->stories->removeElement($story)) {
            // set the owning side to null (unless already changed)
            if ($story->getSchedule() === $this) {
                $story->setSchedule(null);
            }
        }

        return $this;
    }

  
}
