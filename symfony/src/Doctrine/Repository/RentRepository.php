<?php
/**
 * User: Oscar Sanchez
 * Date: 4/4/21
 */

namespace App\Doctrine\Repository;


use App\Entity\Rent;
use App\Exception\RentNotFoundException;
use App\Repository\RentRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

class RentRepository extends ServiceEntityRepository implements RentRepositoryInterface
{
    /**
     * MovieRepository constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry,Rent::class);
    }

    /**
     * @param Rent $rent
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Rent $rent): void
    {
      $entityManager = $this->getEntityManager();
      $entityManager->persist($rent);
      $entityManager->flush();
    }

    public function getByUserName(int $idUser): array
    {
       return $this->findBy(['user' => $idUser]);

    }

    /**
     * @param int $id
     * @return Rent
     * @throws RentNotFoundException
     */
    public function getById(int $id): Rent
    {
        /** @var Rent $rent */
        $rent = $this->find($id);

        if(!$rent) {
            throw new RentNotFoundException();
        }

        return $rent;
    }

    public function getAll(): array
    {
        return parent::findAll();
    }
}