<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select(
                'partial event.{id, date, title, description}',
                'partial category.{id, title}',
                'partial author.{id, email}',
                'partial tags.{id, title}'
            )
            ->join('event.category', 'category')
            ->join('event.author', 'author')
            ->leftJoin('event.tags', 'tags')
            ->orderBy('event.date', 'DESC');
    }

    /**
     * Save record.
     *
     * @param Event $event Event entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Event $event): void
    {
        $this->_em->persist($event);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Event $event Event entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Event $event): void
    {
        $this->_em->remove($event);
        $this->_em->flush();
    }

    public function queryByAuthor(User $user): QueryBuilder
    {
        $queryBuilder = $this->queryAll();
        $queryBuilder->andWhere('event.author = :author')
            ->setParameter('author', $user);

        return $queryBuilder;
    }

    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('event');
    }

}
