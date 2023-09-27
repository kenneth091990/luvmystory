<?php

namespace App\Entity;

use App\Entity\Base\BaseEntity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 */

class UserEntity extends BaseEntity
{
    /**
     * @ORM\Column(type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $password;

    /**
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @ORM\Column(name="first_name", type="string", nullable=true)
     */
    protected $firstName;

    /**
     * @ORM\Column(name="middle_name", type="string", nullable=true)
     */
    protected $middleName;

    /**
     * @ORM\Column(name="last_name", type="string", nullable=true)
     */
    protected $lastName;

    /**
     * @ORM\Column(name="email", type="string")
     */
    protected $email;

    /**
     * @ORM\Column(name="phone_no", type="string", nullable=true)
     */
    protected $phoneNo;

        /**
     * @ORM\Column(name="bio", type="text", nullable=true)
     */
    protected $bio;

    /**
     * @ORM\Column(name="gender", type="string", nullable=true)
     */
    protected $gender;

    /**
     * @ORM\Column(name="birth_date", type="datetime", nullable=true)
     */
    protected $birthDate;

    /**
     * @ORM\Column(name="token", type="string", nullable=true)
     */
    protected $token;

    /**
     * @ORM\Column(name="password_token", type="string", nullable=true)
     */
    protected $passwordToken;


      /**
     * @ORM\Column(name="status", type="string")
     */
    protected $status;

    /**
     * @ORM\Column(name="profile_photo_desc", type="string", nullable=true)
     */
    protected $profilePhotoDesc;
    
     /**
     * @ORM\Column(name="parsed_profile_photo_desc", type="string", nullable=true)
     */
    protected $parsedProfilePhotoDesc;

    /**
     * @ORM\OneToMany(targetEntity="ScheduleEntity", mappedBy="user", cascade={"remove"})
     */
    protected $schedules;

    /**
     * @ORM\OneToMany(targetEntity="NotificationEntity", mappedBy="user", cascade={"remove"})
     */
    protected $notifications;

    /**
     * @ORM\OneToMany(targetEntity="CommentEntity", mappedBy="user", cascade={"remove"})
     */
    protected $comments;

     /**
     * @ORM\OneToMany(targetEntity="ShareStoryEntity", mappedBy="user", cascade={"remove"})
     */
    protected $shareStories;

         /**
     * @ORM\OneToMany(targetEntity="StoryLikeEntity", mappedBy="user", cascade={"remove"})
     */
    protected $storyLikes;


   
    public function __construct($data = null)
    {
        $this->schedules = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->shareStories = new ArrayCollection();
        $this->storyLikes = new ArrayCollection();
    }

    /*--------------------------------------------------------------------------------------------------------*/
    /*					User Defined Setters and Getters													  */
    /*--------------------------------------------------------------------------------------------------------*/

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName() {

        return $this->firstName . ' ' . $this->lastName;
    }


      /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return UserEntity
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

        $file = $this->getUploadRootDir() . '/' . $this->parsedProfilePhotoDesc;
        if(!empty($this->profilePhotoDesc) && file_exists($file)) unlink($file);
    }

    /**
     * Get uploadDir
     *
     * @return string
     */
    public function getUploadDir() {

        return '/uploads/profile_photo';
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

        $parsedDesc = $this->parsedProfilePhotoDesc;
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

 

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(?string $middleName): self
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPhoneNo(): ?string
    {
        return $this->phoneNo;
    }

    public function setPhoneNo(?string $phoneNo): self
    {
        $this->phoneNo = $phoneNo;

        return $this;
    }

    /**
     * @return Collection<int, ScheduleEntity>
     */
    public function getSchedules(): Collection
    {
        return $this->schedules;
    }

    public function addSchedule(ScheduleEntity $schedule): self
    {
        if (!$this->schedules->contains($schedule)) {
            $this->schedules[] = $schedule;
            $schedule->setUser($this);
        }

        return $this;
    }

    public function removeSchedule(ScheduleEntity $schedule): self
    {
        if ($this->schedules->removeElement($schedule)) {
            // set the owning side to null (unless already changed)
            if ($schedule->getUser() === $this) {
                $schedule->setUser(null);
            }
        }

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getProfilePhotoDesc(): ?string
    {
        return $this->profilePhotoDesc;
    }

    public function setProfilePhotoDesc(?string $profilePhotoDesc): self
    {
        $this->profilePhotoDesc = $profilePhotoDesc;

        return $this;
    }

    public function getParsedProfilePhotoDesc(): ?string
    {
        return $this->parsedProfilePhotoDesc;
    }

    public function setParsedProfilePhotoDesc(?string $parsedProfilePhotoDesc): self
    {
        $this->parsedProfilePhotoDesc = $parsedProfilePhotoDesc;

        return $this;
    }

    /**
     * @return Collection<int, NotificationEntity>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(NotificationEntity $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setUser($this);
        }

        return $this;
    }

    public function removeNotification(NotificationEntity $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getUser() === $this) {
                $notification->setUser(null);
            }
        }

        return $this;
    }

    public function getPasswordToken(): ?string
    {
        return $this->passwordToken;
    }

    public function setPasswordToken(?string $passwordToken): self
    {
        $this->passwordToken = $passwordToken;

        return $this;
    }

    /**
     * @return Collection<int, CommentEntity>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(CommentEntity $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(CommentEntity $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ShareStoryEntity>
     */
    public function getShareStories(): Collection
    {
        return $this->shareStories;
    }

    public function addShareStory(ShareStoryEntity $shareStory): self
    {
        if (!$this->shareStories->contains($shareStory)) {
            $this->shareStories[] = $shareStory;
            $shareStory->setUser($this);
        }

        return $this;
    }

    public function removeShareStory(ShareStoryEntity $shareStory): self
    {
        if ($this->shareStories->removeElement($shareStory)) {
            // set the owning side to null (unless already changed)
            if ($shareStory->getUser() === $this) {
                $shareStory->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StoryLikeEntity>
     */
    public function getStoryLikes(): Collection
    {
        return $this->storyLikes;
    }

    public function addStoryLike(StoryLikeEntity $storyLike): self
    {
        if (!$this->storyLikes->contains($storyLike)) {
            $this->storyLikes[] = $storyLike;
            $storyLike->setUser($this);
        }

        return $this;
    }

    public function removeStoryLike(StoryLikeEntity $storyLike): self
    {
        if ($this->storyLikes->removeElement($storyLike)) {
            // set the owning side to null (unless already changed)
            if ($storyLike->getUser() === $this) {
                $storyLike->setUser(null);
            }
        }

        return $this;
    }

       
}
