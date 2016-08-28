<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class RepoRepository extends EntityRepository
{
    public function follow(User $user, Repo $repo)
    {
        $repo->addFollower($user);
        $user->addFollowedRepo($repo);

        $em = $this->getEntityManager();
        $em->flush($repo);
        $em->flush($user);
    }
}
