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
}
