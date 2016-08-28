<?php

namespace AppBundle\Entity;

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
}
