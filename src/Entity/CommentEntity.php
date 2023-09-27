<?php

namespace App\Entity;

use App\Entity\Base\BaseEntity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 * @ORM\Table(name="comment")
 * @ORM\HasLifecycleCallbacks()
 */

class CommentEntity extends BaseEntity
{
    /**
     * @ORM\Column(type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    protected $message;

    /**
     * @ORM\Column(name="email", type="text", nullable=true)
     */
    protected $email;

    
    /**
     * @ORM\Column(name="guest_name", type="text", nullable=true)
     */
    protected $guestName;
    
    /**
     * @ORM\ManyToOne(targetEntity="StoryEntity", inversedBy="comments")
     * @ORM\JoinColumn(name="story_id", referencedColumnName="id")
     */
    protected $story;

    /**
     * @ORM\OneToOne(targetEntity="NotificationEntity", mappedBy="comment", cascade={"remove"})
     */
    protected $notification;

    /**
     * @ORM\ManyToOne(targetEntity="UserEntity", inversedBy="comments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
   
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
     * @return CommentEntity
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }


   
    /*--------------------------------------------------------------------------------------------------------*/
    /*					    Defined Setters and Getters													      */
    /*--------------------------------------------------------------------------------------------------------*/

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getStory(): ?StoryEntity
    {
        return $this->story;
    }

    public function setStory(?StoryEntity $story): self
    {
        $this->story = $story;

        return $this;
    }

    public function getNotification(): ?NotificationEntity
    {
        return $this->notification;
    }

    public function setNotification(?NotificationEntity $notification): self
    {
        // unset the owning side of the relation if necessary
        if ($notification === null && $this->notification !== null) {
            $this->notification->setComment(null);
        }

        // set the owning side of the relation if necessary
        if ($notification !== null && $notification->getComment() !== $this) {
            $notification->setComment($this);
        }

        $this->notification = $notification;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getGuestName(): ?string
    {
        return $this->guestName;
    }

    public function setGuestName(?string $guestName): self
    {
        $this->guestName = $guestName;

        return $this;
    }

  
}
