<?php

namespace App\Service;

use App\Entity\Task;
use App\Exception\EntityNotFoundException;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
class TaskService implements EntityServiceInterface
{
    private TaskRepository $repository;
    private EntityManagerInterface $entityManager;
    private AuthorizationCheckerInterface $authorizationChecker; 


    public function __construct(EntityManagerInterface $entityManager,AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Task::class);
        $this->authorizationChecker = $authorizationChecker; 

    }
    
    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function getOne(int $id)
    {
        $task = $this->repository->find($id);
        if (!$task) {
            throw new EntityNotFoundException($id, Task::class);
        }
        return $task;
    }

    public function create(array $data)
    {
        if (!$this->authorizationChecker->isGranted('ROLE_USER')) {
            throw new AccessDeniedException('Access denied.');
        }
    
        $task = new Task();
        $task->setTitle($data['title']);
        $task->setDescription($data['description']);
        $task->setCreatedAt(new \DateTime());  
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    
        return $task;
    }
    public function update(int $id, array $data)
    {
        $task = $this->getOne($id);

        $task->setTitle($data['title']);
        $task->setDescription($data['description']);

        $this->entityManager->flush();

        return $task;
    }

    public function delete(int $id)
    {
        $task = $this->getOne($id);

        $this->entityManager->remove($task);
        $this->entityManager->flush();
    }
}
