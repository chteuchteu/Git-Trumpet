<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        $params = [];

        if ($this->getUser() != null) {
            // Keep starred repos in session to avoid API flood
            if (!$request->getSession()->has('starred-repos'))
                $request->getSession()->set('starred-repos', $this->get('app.github')->getStarredRepos());

            $params['starred'] = $request->getSession()->get('starred-repos');
        }

        return $this->render('AppBundle::index.html.twig', $params);
    }
}
