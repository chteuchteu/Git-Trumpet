<?php

namespace AppBundle\Security\Core\User;

use AppBundle\Entity\User;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseFOSUBProvider;
use Symfony\Component\Security\Core\User\UserInterface;

class FOSUBUserProvider extends BaseFOSUBProvider
{
    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $u, UserResponseInterface $response)
    {
        $username = $response->getUsername(); // get the unique user identifier

        //we "disconnect" previously connected users
        /** @var User $existingUser */
        $existingUser = $this->userManager->findUserBy(['githubId' => $username]);
        if (null !== $existingUser) {
            // set current user id and token to null for disconnect
            $existingUser->setGithubId(null);
            $existingUser->setGithubAccessToken(null);

            $this->userManager->updateUser($existingUser);
        }

        /** @var User $user */
        $user = $u;
        $user->setGithubId($username);
        $user->setGithubAccessToken($response->getAccessToken());
        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $user = $this->userManager->findUserBy(['githubId' => $response->getUsername()]);

        if ($user === null) {
            /** @var User $user */
            $user = $this->userManager->createUser();
            $user
                ->setGithubId($response->getUsername())
                ->setGithubAccessToken($response->getAccessToken())
                ->setUsername($response->getNickname())
                ->setRealName($response->getRealName())
                ->setEmail($response->getEmail())
                ->setPassword($response->getUsername()) // Just so it's not null
                ->setEnabled(true);

            $this->userManager->updateUser($user);
            return $user;
        }

        // User exists
        /** @var User $user */
        $user = parent::loadUserByOAuthUserResponse($response);
        $user->setGithubAccessToken($response->getAccessToken());

        return $user;
    }
}
