<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\RepoRepository")
 */
class Repo
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="owner", type="string", length=255)
     */
    protected $owner;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=255)
     */
    protected $url;

    /**
     * @var Collection|User[]
     * @ORM\ManyToMany(targetEntity="User", mappedBy="followedRepos")
     */
    protected $followers;

    /**
     * @var \DateTime
     * @ORM\Column(name="lastCheck", type="datetime")
     */
    protected $lastCheck;


    public function __construct()
    {
        $this->followers = new ArrayCollection();
        $this->lastCheck = new \DateTime();
    }


    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Repo
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return Repo
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Repo
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param User $follower
     * @return Repo
     */
    public function addFollower(User $follower)
    {
        $this->followers[] = $follower;
        return $this;
    }

    /**
     * @param User $follower
     */
    public function removeFollower(User $follower)
    {
        $this->followers->removeElement($follower);
    }

    /**
     * @return Collection
     */
    public function getFollowers()
    {
        return $this->followers;
    }
}
