<?php

/*
 * This file is part of the DeadPool Bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Handler\GitLastRequestHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @author Michael COULLERET <michael@coulleret.pro>
 * @author Florent DESPIERRES <florent@despierres.pro>
 */
class WebhookController extends AbstractController
{
    /**
     * Webhook gitlab.
     *
     * @param Request               $request
     * @param GitLastRequestHandler $gitLastRequestHandler
     *
     * @Route("/webhooks/gitlab", name="webhooks_gitlab")
     * @Method("POST")
     *
     * @return JsonResponse
     */
    public function gitlabAction(Request $request, GitLastRequestHandler $gitLastRequestHandler): JsonResponse
    {
        $responseData = $gitLastRequestHandler->handle($request);

        return new JsonResponse($responseData);
    }
}
