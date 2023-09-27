<?php

namespace App\Entity;

use App\Entity\Base\BaseEntity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StoryRepository")
 * @ORM\Table(name="story")
 * @ORM\HasLifecycleCallbacks()
 */

class StoryEntity extends BaseEntity
{
    /**
     * @ORM\Column(type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

     /**
     * @ORM\Column(name="is_read", type="boolean", nullable=true)
     */
    protected $isRead;

     /**
     * @ORM\Column(name="is_public", type="boolean", nullable=true)
     */
    protected $isPublic;

    /**
     * @ORM\Column(name="file_desc", type="string", nullable=true)
     */
    protected $fileDesc;
    
     /**
     * @ORM\Column(name="parsed_file_desc", type="string", nullable=true)
     */
    protected $parsedFileDesc;

    /**
     * @ORM\ManyToOne(targetEntity="ScheduleEntity", inversedBy="stories")
     * @ORM\JoinColumn(name="schedule_id", referencedColumnName="id")
     */
    protected $schedule;

    /**
     * @ORM\OneToMany(targetEntity="NotificationEntity", mappedBy="story", cascade={"remove"})
     */
    protected $notifications;

    
    /**
     * @ORM\OneToMany(targetEntity="CommentEntity", mappedBy="story", cascade={"remove"})
     */
    protected $comments;

    /**
     * @ORM\OneToMany(targetEntity="ShareStoryEntity", mappedBy="story", cascade={"remove"})
     */
    protected $shareStories;

    /**
     * @ORM\OneToMany(targetEntity="StoryLikeEntity", mappedBy="story", cascade={"remove"})
     */
    protected $storyLikes;
   
    public function __construct($data = null)
    {
        $this->comments = new ArrayCollection();
        $this->shareStories = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->storyLikes = new ArrayCollection();
    }

    /*--------------------------------------------------------------------------------------------------------*/
    /*					User Defined Setters and Getters													  */
    /*--------------------------------------------------------------------------------------------------------*/

    /**
     * Get storyLikeUserIds
     *
     * @return array
     */
    public function storyLikeUserIds() {
        $ids = [];

        foreach ($this->storyLikes as $c){

            if(!$c->isIsDeleted()){
                $ids[] = $c->getUser()->getId();
            }
        }

        return $ids;
    }

    /**
     * Get sharedStoriesIds
     *
     * @return array
     */
    public function sharedStoriesIds() {
        $ids = [];

        foreach ($this->shareStories as $c){

            if(!$c->isIsDeleted()){
                $ids[] = $c->getUser()->getId();
            }
        }

        return $ids;
    }


      /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return StoryEntity
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

        return '/uploads/story';
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

    public function isIsRead(): ?bool
    {
        return $this->isRead;
    }

    public function setIsRead(?bool $isRead): self
    {
        $this->isRead = $isRead;

        return $this;
    }

    public function isIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(?bool $isPublic): self
    {
        $this->isPublic = $isPublic;

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

    public function getSchedule(): ?ScheduleEntity
    {
        return $this->schedule;
    }

    public function setSchedule(?ScheduleEntity $schedule): self
    {
        $this->schedule = $schedule;

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
            $notification->setStory($this);
        }

        return $this;
    }

    public function removeNotification(NotificationEntity $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getStory() === $this) {
                $notification->setStory(null);
            }
        }

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
            $comment->setStory($this);
        }

        return $this;
    }

    public function removeComment(CommentEntity $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getStory() === $this) {
                $comment->setStory(null);
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
            $shareStory->setStory($this);
        }

        return $this;
    }

    public function removeShareStory(ShareStoryEntity $shareStory): self
    {
        if ($this->shareStories->removeElement($shareStory)) {
            // set the owning side to null (unless already changed)
            if ($shareStory->getStory() === $this) {
                $shareStory->setStory(null);
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
            $storyLike->setStory($this);
        }

        return $this;
    }

    public function removeStoryLike(StoryLikeEntity $storyLike): self
    {
        if ($this->storyLikes->removeElement($storyLike)) {
            // set the owning side to null (unless already changed)
            if ($storyLike->getStory() === $this) {
                $storyLike->setStory(null);
            }
        }

        return $this;
    }

  


    
}
