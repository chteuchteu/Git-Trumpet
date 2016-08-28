<?php

namespace AppBundle\Service;

use AppBundle\Entity\Repo;
use AppBundle\Entity\User;
use Github\Client;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class GitHubService
{
    /** @var User */
    private $user;

    /** @var string */
    private $githubClientId;

    /** @var string */
    private $githubClientSecret;


    public function __construct(TokenStorage $tokenStorage, $githubClientId, $githubClientSecret)
    {
        $this->user = $tokenStorage->getToken()->getUser();
        $this->githubClientId = $githubClientId;
        $this->githubClientSecret = $githubClientSecret;
    }


    /**
     * @return \Github\Client
     */
    private function getGitHubClient()
    {
        $client = new Client();
        $client->authenticate($this->githubClientId, $this->githubClientSecret, Client::AUTH_URL_CLIENT_ID);
        return $client;
    }

    /**
     * Get logged-in user starred repositories
     * @return array
     */
    public function getStarredRepos()
    {
        /** @var \GitHub\Api\User $userApi */
        $userApi = $this->getGitHubClient()->api('user');

        $starred = [];
        $page = 1;

        while (count($list = $userApi->starred($this->user->getUsername(), $page++)) > 0)
            $starred = array_merge($starred, $list);

        return $starred;
    }

    public function getRepo($owner, $name)
    {
        /** @var \GitHub\Api\Repo $reposApi */
        $reposApi = $this->getGitHubClient()->api('repos');

        try {
            return $reposApi->show($owner, $name);
        } catch (\Exception $ex) {
            return null;
        }
    }
}
