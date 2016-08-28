<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Repo;
use AppBundle\Entity\RepoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api")
 */
class APIController extends Controller
{
    /**
     * @Route("/follow")
     * @Method({"POST"})
     */
    public function followRepositoryAction(Request $request)
    {
        if (!$this->getUser())
            return self::response(false, "You must be logged in to perform this action");

        $post = $request->request;
        if (!$post->has('name') || !$post->has('owner') || !$post->has('url'))
            return self::response(false, "Missing arguments");

        $em = $this->getDoctrine()->getManager();
        /** @var RepoRepository $repoRepo */
        $repoRepo = $em->getRepository('AppBundle:Repo');

        $repoName = $post->get('name');
        $repoOwner = $post->get('owner');
        $repoUrl = $post->get('url');

        // Check if it is known
        $repo = $repoRepo->findOneBy([
            'name' => $repoName,
            'owner' => $repoOwner
        ]);

        if (!$repo) {
            $repo = new Repo();
            $repo
                ->setName($repoName)
                ->setOwner($repoOwner)
                ->setUrl($repoUrl);

            $em->persist($repo);
        }

        $this->getDoctrine()->getManager()->getRepository('AppBundle:Repo')->follow(
            $this->getUser(),
            $repo
        );
        $em->flush();

        return self::response();
    }


    private static function response($success=true, $message=null)
    {
        return new JsonResponse([
            'success' => $success,
            'message' => $message
        ]);
    }
}
