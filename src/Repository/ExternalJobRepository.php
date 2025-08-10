<?php

namespace App\Repository;

use App\Entity\ExternalJob;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExternalJob>
 */
class ExternalJobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExternalJob::class);
    }

    public function findOneByExternalId(string $externalId): ?ExternalJob
    {
        return $this->findOneBy(['externalId' => $externalId]);
    }

    /**
     * @return ExternalJob[]
     */
    public function findAllOrderedByFetchedAtDesc(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.fetchedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
