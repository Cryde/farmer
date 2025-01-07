<?php

namespace App\Repository\Farm;

use App\Entity\Farm\Farm;
use App\Entity\Farm\FarmTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FarmTransaction>
 */
class FarmTransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FarmTransaction::class);
    }

    public function getTotalByFarm(Farm $farm): string|int
    {
        return $this->createQueryBuilder('farm_transaction')
            ->select('SUM(farm_transaction.amount)')
            ->where('farm_transaction.relatedFarm = :farm')
            ->setParameter('farm', $farm)
            ->getQuery()
            ->getSingleScalarResult() ?? 0;
    }

    public function findByFarm(Farm $farm): array
    {
        return $this->createQueryBuilder('farm_transaction')
            ->where('farm_transaction.relatedFarm = :farm')
            ->setParameter('farm', $farm)
            ->orderBy('farm_transaction.creationDatetime', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
