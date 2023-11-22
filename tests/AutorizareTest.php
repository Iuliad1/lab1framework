<?php
use App\Entity\Task; 
use App\Service\TaskService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\Repository\TaskRepository;

class AutorizareTest extends TestCase
{
    public function testCreateTaskForAuthenticatedUser(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $taskRepository = $this->createMock(TaskRepository::class);

        $entityManager->expects($this->once())
        ->method('getRepository')
        ->with(Task::class)
        ->willReturn($taskRepository);

        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $authorizationChecker->expects($this->once())
            ->method('isGranted')
            ->with('ROLE_USER')
            ->willReturn(true);
        $taskService = new TaskService($entityManager, $authorizationChecker);
    
        $taskData = [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'dueDate' => '2023-12-31',
        ];
    
        $this->assertTrue(true);
        $taskService->create($taskData);
    }
    
    public function testCreateTaskForUnauthenticatedUser(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $taskRepository = $this->createMock(TaskRepository::class);
        
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->with(Task::class)
            ->willReturn($taskRepository);

        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $authorizationChecker->expects($this->once())
            ->method('isGranted')
            ->with('ROLE_USER')
            ->willReturn(false);
        $taskService = new TaskService($entityManager, $authorizationChecker);

        $taskData = [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'dueDate' => '2023-12-31',
        ];

        $this->expectException(AccessDeniedException::class);
    $taskService->create($taskData);
    }
}

?>
