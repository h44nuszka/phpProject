<?php
/**
 * Users data service
 */

namespace App\Service;

use App\Entity\UsersData;
use App\Repository\UsersDataRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UsersDataService.
 */
class UsersDataService
{
    private UsersDataRepository $usersDataRepository;
    private PaginatorInterface $paginator;

    /**
     * UsersDataService constructor.
     * @param \App\Repository\UsersDataRepository     $usersDataRepository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator
     */
    public function __construct(UsersDataRepository $usersDataRepository, PaginatorInterface $paginator)
    {
        $this->usersDataRepository = $usersDataRepository;
        $this->paginator = $paginator;
    }

    /**
     * Create paginated list.
     *
     * @param int           $page Page number
     * @param UserInterface $user User entity
     *
     * @return PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page, UserInterface $user): PaginationInterface
    {

        return $this->paginator->paginate(
            $this->usersDataRepository->queryByAuthor($user),
            $page,
            UsersDataRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }


    /**
     * @param \App\Entity\UsersData                               $usersData
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(UsersData $usersData, UserInterface $user): void
    {
        if ($usersData->getId()) {
            $usersData->setAuthor($user);
        }
        $this->usersDataRepository->save($usersData);
    }

    /**
     * Delete usersData.
     *
     * @param \App\Entity\UsersData $usersData UsersData entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(UsersData $usersData): void
    {
        $this->usersDataRepository->delete($usersData);
    }
}
