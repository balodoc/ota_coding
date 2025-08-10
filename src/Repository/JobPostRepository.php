<?php

namespace App\Repository;

use App\Entity\JobPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JobPost>
 */
class JobPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobPost::class);
    }

    public function countPriorPostsByEmailExcludingId(string $email, int $excludeJobId): int
    {
        return (int) $this->createQueryBuilder('j')
            ->select('COUNT(j.id)')
            ->where('j.posterEmail = :email')
            ->andWhere('j.id != :id')
            ->setParameter('email', $email)
            ->setParameter('id', $excludeJobId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return JobPost[]
     */
    public function findPublishedOrderedByCreatedAtDesc(): array
    {
        return $this->createQueryBuilder('j')
            ->where('j.status = :status')
            ->setParameter('status', JobPost::STATUS_PUBLISHED)
            ->orderBy('j.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return JobPost[]
     */
    public function findInternalJobsOrderedByCreatedAtDesc(): array
    {
        return $this->createQueryBuilder('j')
            ->where('j.jobType = :jobType')
            ->andWhere('j.status = :status')
            ->setParameter('jobType', JobPost::TYPE_INTERNAL)
            ->setParameter('status', JobPost::STATUS_PUBLISHED)
            ->orderBy('j.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return JobPost[]
     */
    public function findExternalJobsOrderedByFetchedAtDesc(): array
    {
        return $this->createQueryBuilder('j')
            ->where('j.jobType = :jobType')
            ->setParameter('jobType', JobPost::TYPE_EXTERNAL)
            ->orderBy('j.fetchedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find external job by external ID.
     */
    public function findOneByExternalId(string $externalId): ?JobPost
    {
        return $this->createQueryBuilder('j')
            ->where('j.jobType = :jobType')
            ->andWhere('j.externalId = :externalId')
            ->setParameter('jobType', JobPost::TYPE_EXTERNAL)
            ->setParameter('externalId', $externalId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
