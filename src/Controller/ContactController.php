<?php
/**
 * Contact Controller.
 */

namespace App\Controller;

use App\Entity\UsersData;
use App\Form\UsersDataType;
use App\Repository\UsersDataRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactController.
 *
 * @Route("/contact")
 *
 * @IsGranted("ROLE_USER")
 */
class ContactController extends AbstractController
{
    /**
     * Contact repository.
     */
    private UsersDataRepository $usersDataRepository;

    private PaginatorInterface $paginator;

    /**
     * Contact Controller constructor.
     */
    public function __construct(UsersDataRepository $usersDataRepository, PaginatorInterface $paginator)
    {
        $this->usersDataRepository = $usersDataRepository;
        $this->paginator = $paginator;
    }

    /**
     * Index action.
     *
     * @param Request             $request             HTTP request
     * @param UsersDataRepository $usersDataRepository Users Data repository
     * @param PaginatorInterface  $paginator           Paginator
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="contact_index"
     * )
     */
    public function index(Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $this->usersDataRepository->queryByAuthor($this->getUser()),
            $request->query->getInt('page', 1),
            UsersDataRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'contact/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param UsersData $usersData Users data entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="contact_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     *     * @IsGranted(
     *     "VIEW",
     *     subject="usersData"
     * )
     *
     */
    public function show(UsersData $usersData): Response
    {
        if ($usersData->getAuthor() !== $this->getUser()) {
            $this->addFlash('warning', 'message.item_not_found');

            return $this->redirectToRoute('contact_index');
        }
        return $this->render(
            'contact/contact.html.twig',
            ['usersData' => $usersData]
        );
    }

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request             HTTP request
     * @param \App\Repository\UsersDataRepository       $usersDataRepository usersData repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="contact_create",
     * )
     */
    public function create(Request $request, UsersDataRepository $usersDataRepository): Response
    {
        $usersData = new UsersData();
        $form = $this->createForm(UsersDataType::class, $usersData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usersData->setAuthor($this->getUser());
            $usersDataRepository->save($usersData);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('contact_index');
        }

        return $this->render(
            'contact/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request             HTTP request
     * @param \App\Entity\UsersData                     $usersData           users Data entity
     * @param \App\Repository\UsersDataRepository       $usersDataRepository users Data repository
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
     *     name="contact_edit",
     * )
     *
     * @IsGranted(
     *     "EDIT",
     *     subject="usersData"
     * )
     */
    public function edit(Request $request, UsersData $usersData, UsersDataRepository $usersDataRepository): Response
    {
        if ($usersData->getAuthor() !== $this->getUser()) {
            $this->addFlash('warning', 'message.item_not_found');

            return $this->redirectToRoute('contact_index');
        }

        $form = $this->createForm(UsersDataType::class, $usersData, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usersDataRepository->save($usersData);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('contact_index');
        }

        return $this->render(
            'contact/edit.html.twig',
            [
                'form' => $form->createView(),
                'usersData' => $usersData,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request             HTTP request
     * @param \App\Entity\UsersData                     $usersData           usersData entity
     * @param \App\Repository\UsersDataRepository       $usersDataRepository usersData repository
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
     *     name="contact_delete",
     * )
     * @IsGranted(
     *     "DELETE",
     *     subject="usersData"
     * )
     */
    public function delete(Request $request, UsersData $usersData, UsersDataRepository $usersDataRepository): Response
    {
        if ($usersData->getAuthor() !== $this->getUser()) {
            $this->addFlash('warning', 'message.item_not_found');

            return $this->redirectToRoute('contact_index');
        }

        $form = $this->createForm(FormType::class, $usersData, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $usersDataRepository->delete($usersData);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('contact_index');
        }

        return $this->render(
            'contact/delete.html.twig',
            [
                'form' => $form->createView(),
                'usersData' => $usersData,
            ]
        );
    }
}
