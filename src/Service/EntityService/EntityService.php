<?php
declare(strict_types=1);

namespace Tims3l\RestApi\Service\EntityService;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EntityService implements EntityServiceInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        private readonly ManagerRegistry $doctrine, 
        private readonly ValidatorInterface $validator)
    {
        $this->entityManager = $this->doctrine->getManager();
    }

    public function validate(object $entity): ConstraintViolationListInterface
    {
        return $this->validator->validate($entity);
    }

    public function save(object $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
    
    public function remove(object $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
    
    public function getAllEntityClassnames(): array
    {
        return $this->entityManager->getConfiguration()->getMetadataDriverImpl()->getAllClassNames();
    }
    
    public function getRepository(string $class): ObjectRepository
    {
        return $this->entityManager->getRepository($class);
    }
}