<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TaskRepository;
use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


class TaskController extends AbstractController
{
    #[Route('/task', name: 'app_task')]
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }

    #[Route('/task/create', name: 'taskcreate')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
    
        if (!($form->isSubmitted() && $form->isValid())) {
            return $this->render('task/create.html.twig', [
                'task_form' => $form,
            ]);
        }
    
        $entityManager->persist($task);
        $entityManager->flush();
    
        return $this->redirectToRoute('taskupdate', ['id' => $task->getId()]);
    }

    #[Route('/task/update/{id}', name: 'taskupdate')]
    public function update(int $id,TaskRepository $TaskRepository): Response
    {
        $task= $TaskRepository->find($id);
    $form = $this->createForm(TaskType::class, $task);
    return $this->render('task/create.html.twig',[
    'task_form' => $form,
    ]);
}

    #[Route('/task/delete/{id}', name: 'taskdelete')]
    public function delete(int $id, TaskRepository $taskRepository, EntityManagerInterface $entityManager): Response
    {
        $task = $taskRepository->find($id);
    
        if (!$task) {
            throw $this->createNotFoundException('Task not found');
        }
    
        $entityManager->remove($task);
        $entityManager->flush();
    
        return $this->redirectToRoute('taskcreate'); 
    }
}    
?>