<?php

namespace App\Entity;

use App\Entity\Base\BaseEntity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StoryLikeRepository")
 * @ORM\Table(name="story_like")
 * @ORM\HasLifecycleCallbacks()
 */

class StoryLikeEntity extends BaseEntity
{
    /**
     * @ORM\Column(type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="StoryEntity", inversedBy="storyLikes")
     * @ORM\JoinColumn(name="story_id", referencedColumnName="id")
     */
    protected $story;


    /**
     * @ORM\ManyToOne(targetEntity="UserEntity", inversedBy="storyLikes")
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
     * @return StoryLikeEntity
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

    public function getStory(): ?StoryEntity
    {
        return $this->story;
    }

    public function setStory(?StoryEntity $story): self
    {
        $this->story = $story;

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


  
}
