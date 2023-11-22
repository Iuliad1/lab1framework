<?php
use App\Entity\Task; 
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User; // Asigură-te că ai importat clasa User

class CreereTaskIntegrationTest extends WebTestCase
{
    public function testCreateTask(): void
    {
        // Boot the Symfony kernel
        self::bootKernel();
        
        // Obține containerul de servicii
        $container = static::getContainer();
        
        // Obține serviciul TaskService din container
        $taskService = $container->get(TaskService::class);

        // Creează un utilizator cu rolul necesar
        $user = new User();
        $user->setRoles(['ROLE_USER']);

        // Emulează autentificarea utilizatorului
        $client = static::createClient();
        $client->loginUser($user);

        // Datele pentru crearea unei sarcini
        $taskData = [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'dueDate' => '2023-12-31',
        ];

        // Încearcă să creezi o sarcină
        $createdTask = $taskService->create($taskData);

        // Verifică rezultatul
        $this->assertInstanceOf(Task::class, $createdTask);
        $this->assertEquals('Test Task', $createdTask->getTitle());
        $this->assertEquals('Test Description', $createdTask->getDescription());
        $this->assertEquals(new \DateTime('2023-12-31'), $createdTask->getDueDate());
    }
}