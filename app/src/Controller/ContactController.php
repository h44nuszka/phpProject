<?php
/**
 * Contact Controller.
 */

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactController.
 *
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * Contact repository.
     */
    private ContactRepository $repository;

    /**
     * Contact Controller constructor.
     *
     * @param ContactRepository $repository Contact repository
     */
    public function __construct(ContactRepository $repository)
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
     *     name="contact_index"
     * )
     */
    public function index(): Response
    {
        $data = $this->repository->findAll();
        return $this->render(
            'contact/index.html.twig',
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
            'contact/contact.html.twig',
            ['item' => $item]
        );
    }

}
