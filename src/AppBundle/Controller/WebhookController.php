<?php

/*
 * This file is part of the DeadPool Bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Handler\GitLastRequestHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Webhook controller.
 *
 * @author Michael COULLERET <michael.coulleret@gmail.com>
 * @author Florent DESPIERRES <orions07@gmail.com>
 */
class WebhookController extends Controller
{
    /**
     * Weebhook gitlab.
     *
     * @param Request               $request
     * @param GitLastRequestHandler $gitLastRequestHandler
     *
     * @Route("/webhooks/gitlab", name="webhooks_gitlab")
     * @Method("POST")
     *
     * @return JsonResponse
     */
    public function gitlabAction(Request $request, GitLastRequestHandler $gitLastRequestHandler)
    {
        $responseData = $gitLastRequestHandler->handle($request);

        return new JsonResponse($responseData);
    }
}
