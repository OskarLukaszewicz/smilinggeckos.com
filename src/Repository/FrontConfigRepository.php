<?php

namespace App\Repository;

use App\Entity\FrontConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FrontConfig>
 *
 * @method FrontConfig|null find($id, $lockMode = null, $lockVersion = null)
 * @method FrontConfig|null findOneBy(array $criteria, array $orderBy = null)
 * @method FrontConfig[]    findAll()
 * @method FrontConfig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FrontConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FrontConfig::class);
    }

    public function add(FrontConfig $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FrontConfig $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
