<?php

namespace App\Repository;

use App\Entity\Gecko;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Gecko>
 *
 * @method Gecko|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gecko|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gecko[]    findAll()
 * @method Gecko[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeckoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gecko::class);
    }

    public function add(Gecko $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Gecko $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
