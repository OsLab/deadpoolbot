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

use App\Repository\MergeRequestRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Controller used to show the latest merge request.
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 * @author Florent DESPIERRES <florent@despierres.pro>
 */
class BoardController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1"}, name="board")
     * @Method("GET")
     *
     * @Cache(smaxage="0")
     *
     * @param MergeRequestRepository $mergeRequest
     *
     * @return Response
     */
    public function indexAction(int $page, MergeRequestRepository $mergeRequest): Response
    {
        return $this->render('board/index.html.twig', [
            'mergeRequests' => $mergeRequest->findLatest($page)
        ]);
    }
}
