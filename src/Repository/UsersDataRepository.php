<?php
/**
 * Users Data Repository
 */

namespace App\Repository;

use App\Entity\User;
use App\Entity\UsersData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UsersData|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersData|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersData[]    findAll()
 * @method UsersData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersDataRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     * @constant int
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * UsersDataRepository constructor.
     * @param \Doctrine\Persistence\ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersData::class);
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select(
                'partial usersData.{id, name, surname, nick, phoneNumber, birthDate}',
                'partial author.{id, email}'
            )
            ->join('usersData.author', 'author')
            ->orderBy('usersData.name', 'DESC');
    }

    /**
     * Save record.
     *
     * @param UsersData $usersData usersData entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(UsersData $usersData): void
    {
        $this->_em->persist($usersData);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\UsersData $usersData usersData entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(UsersData $usersData): void
    {
        $this->_em->remove($usersData);
        $this->_em->flush();
    }

    /**
     * @param \App\Entity\User $user
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function queryByAuthor(User $user): QueryBuilder
    {
        $queryBuilder = $this->queryAll();
        $queryBuilder->andWhere('usersData.author = :author')
            ->setParameter('author', $user);

        return $queryBuilder;
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder|null $queryBuilder
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('usersData');
    }
}
