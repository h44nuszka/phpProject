<?php
/**
 * Event Controller.
 */

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventController.
 *
 * @Route("/event")
 *
 * @IsGranted("ROLE_USER")
 */
class EventController extends AbstractController
{
    /**
     * Event repository.
     */
    private EventRepository $eventRepository;

    private PaginatorInterface $paginator;

    /**
     * EventController constructor.
     */
    public function __construct(EventRepository $eventRepository, PaginatorInterface $paginator)
    {
        $this->eventRepository = $eventRepository;
        $this->paginator = $paginator;
    }

    /**
     * Index action.
     *
     * @param Request            $request         HTTP request
     * @param EventRepository    $eventRepository Event repository
     * @param PaginatorInterface $paginator       Paginator
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="event_index"
     * )
     */
    public function index(Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $this->eventRepository->queryByAuthor($this->getUser()),
            $request->query->getInt('page', 1),
            EventRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'timetable/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param Event $event Event entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="event_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     * @IsGranted(
     *     "VIEW",
     *     subject="event"
     * )
     */
    public function show(Event $event): Response
    {
        return $this->render(
            'timetable/event.html.twig',
            ['event' => $event]
        );
    }

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request         HTTP request
     * @param \App\Repository\EventRepository           $eventRepository event repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="event_create",
     * )
     */
    public function create(Request $request, EventRepository $eventRepository): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->setAuthor($this->getUser());
            $eventRepository->save($event);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('event_index');
        }

        return $this->render(
            'timetable/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request         HTTP request
     * @param \App\Entity\Event                         $event           Event entity
     * @param \App\Repository\EventRepository           $eventRepository Event repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="event_edit",
     * )
     * @IsGranted(
     *     "EDIT",
     *     subject="event"
     * )
     */
    public function edit(Request $request, Event $event, EventRepository $eventRepository): Response
    {
        $form = $this->createForm(EventType::class, $event, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventRepository->save($event);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('event_index');
        }

        return $this->render(
            'timetable/edit.html.twig',
            [
                'form' => $form->createView(),
                'event' => $event,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request         HTTP request
     * @param \App\Entity\Event                         $event           Event entity
     * @param \App\Repository\EventRepository           $eventRepository Event repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="event_delete",
     * )
     * @IsGranted(
     *     "DELETE",
     *     subject="event"
     * )
     */
    public function delete(Request $request, Event $event, EventRepository $eventRepository): Response
    {
        if ($event->getAuthor() !== $this->getUser()) {
            $this->addFlash('warning', 'message.item_not_found');

            return $this->redirectToRoute('event_index');
        }

        $form = $this->createForm(FormType::class, $event, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $eventRepository->delete($event);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('event_index');
        }

        return $this->render(
            'timetable/delete.html.twig',
            [
                'form' => $form->createView(),
                'event' => $event,
            ]
        );
    }
}