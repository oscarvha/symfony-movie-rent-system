<?php
/**
 * User: Oscar Sanchez
 * Date: 2/4/21
 */

namespace App\Doctrine\Repository;



use App\Entity\Movie;
use App\Exception\MovieNotFoundException;
use App\Repository\MovieRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

class MovieRepository extends ServiceEntityRepository implements MovieRepositoryInterface
{

    /**
     * MovieRepository constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry,Movie::class);
    }


    /**
     * @param Movie $movie
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Movie $movie): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($movie);
        $entityManager->flush();
    }

    public function findByTitle(string $tile): ?Movie
    {
        return $this->findOneBy(['title' => $tile]);
    }

    public function findByReference(string $reference): ?Movie
    {
        return $this->findOneBy(['reference' => $reference]);
    }

    public function getAll(): array
    {
        return parent::findAll();
    }

    /**
     * @param int $id
     * @return Movie
     * @throws MovieNotFoundException
     */
    public function getById(int $id): Movie
    {
        /** @var Movie $movie */
        $movie = $this->find($id);

        if(!$movie) {
            throw new MovieNotFoundException();
        }

        return $movie;
    }


    /**
     * @param Movie $movie
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Movie $movie): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($movie);
        $entityManager->flush();
    }

    public function getLast(int $limit): array
    {
        return $this->findBy([],[],$limit);

    }
}