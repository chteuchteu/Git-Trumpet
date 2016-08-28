<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as FOSUBUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class User extends FOSUBUser
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     * @ORM\Column(name="githubId", type="integer")
     */
    private $githubId;

    /**
     * @var string
     * @ORM\Column(name="githubAccessToken", type="string", length=255, nullable=true)
     */
    private $githubAccessToken;

    /**
     * @var string
     * @ORM\Column(name="realName", type="string", length=255)
     */
    private $realName;

    /**
     * @var Collection|Repo[]
     * @ORM\ManyToMany(targetEntity="Repo", inversedBy="followers")
     */
    private $followedRepos;


    public function __construct()
    {
        parent::__construct();
        $this->followedRepos = new ArrayCollection();
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getGithubId()
    {
        return $this->githubId;
    }

    /**
     * @param int $githubId
     * @return User
     */
    public function setGithubId($githubId)
    {
        $this->githubId = $githubId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGithubAccessToken()
    {
        return $this->githubAccessToken;
    }

    /**
     * @param mixed $githubAccessToken
     * @return User
     */
    public function setGithubAccessToken($githubAccessToken)
    {
        $this->githubAccessToken = $githubAccessToken;
        return $this;
    }

    /**
     * @return string
     */
    public function getRealName()
    {
        return $this->realName;
    }

    /**
     * @param string $realName
     * @return User
     */
    public function setRealName($realName)
    {
        $this->realName = $realName;
        return $this;
    }

    /**
     * @param Repo $followedRepo
     * @return User
     */
    public function addFollowedRepo(Repo $followedRepo)
    {
        $this->followedRepos[] = $followedRepo;
        return $this;
    }

    /**
     * @param Repo $followedRepo
     */
    public function removeFollowedRepo(Repo $followedRepo)
    {
        $this->followedRepos->removeElement($followedRepo);
    }

    /**
     * @return Collection
     */
    public function getFollowedRepos()
    {
        return $this->followedRepos;
    }

    /**
     * Returns true if this user follows this specific repo
     * @param $owner
     * @param $name
     * @return bool
     */
    public function followsRepo($owner, $name)
    {
        foreach ($this->followedRepos as $repo)
        {
            if ($repo->getOwner() == $owner && $repo->getName() == $name)
                return true;
        }

        return false;
    }
}
