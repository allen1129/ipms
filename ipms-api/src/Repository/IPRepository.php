<?php

namespace App\Repository;

use App\Entity\IP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IP>
 *
 * @method IP|null find($id, $lockMode = null, $lockVersion = null)
 * @method IP|null findOneBy(array $criteria, array $orderBy = null)
 * @method IP[]    findAll()
 * @method IP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IP::class);
    }

    /**
     * Find an IP entity by ID.
     * @param int $id
     * @return IP|null
     */
    public function findById(int $id): ?IP
    {
        return $this->find($id);
    }

    /**
     * Retrieve all IP entities.
     * @return IP[]
     */
    public function findAllIPs(): array
    {
        return $this->findAll();
    }
}