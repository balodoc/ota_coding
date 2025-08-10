<?php

namespace App\Repository;

use App\Entity\Notification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notification>
 */
class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    /**
     * @return Notification[]
     */
    public function findAllOrderedByCreatedAtDesc(): array
    {
        return $this->createQueryBuilder('n')
            ->where('n.isRead = 0')
            ->orderBy('n.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function countUnread(): int
    {
        return (int) $this->createQueryBuilder('n')
            ->select('COUNT(n.id)')
            ->where('n.isRead = 0')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function markUnreadByJobIdAsRead(int $jobId): int
    {
        return $this->createQueryBuilder('n')
            ->update()
            ->set('n.isRead', ':read')
            ->where('n.jobId = :jobId')
            ->andWhere('n.isRead = 0')
            ->setParameter('read', true)
            ->setParameter('jobId', $jobId)
            ->getQuery()
            ->execute();
    }
}
