<?php
/**
 * Timetable app Controller.
 */

namespace App\Controller;

use App\Repository\EventRepository;
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
     * Event repository.
     */
    private EventRepository $repository;

    /**
     * EventController constructor.
     *
     * @param EventRepository $repository Event repository
     */
    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

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
        $data = $this->repository->findAll();
        return $this->render(
            'timetable/index.html.twig',
            ['data' => $data]
        );
    }


    /**
     * Show action.
     *
     * @param int $id Event id
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="event_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(int $id): Response
    {
        $item = $this->repository->findById($id);

        return $this->render(
            'timetable/event.html.twig',
            ['item' => $item]
        );
    }

}
