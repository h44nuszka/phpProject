<?php
/**
 * Timetable app Controller.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TimetableController.
 *
 * @Route("/timetable")
 */
class TimetableController extends AbstractController
{
    /**
     * Index action.
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="timetable_index"
     * )
     */
    public function index(): Response
    {
        return $this->render(
            'timetable/index.html.twig'
        );
    }
}
