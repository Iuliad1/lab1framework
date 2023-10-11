<?php 
 
namespace App\Controller; 
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\Routing\Annotation\Route; 
use App\Repository\TaskRepository; 
use App\Entity\Task; 
use App\Entity\Category; 
use App\Form\TaskType; 
use Symfony\Component\HttpFoundation\Request; 
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Paginator;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Knp\Component\Pager\PaginatorInterface;

class TaskController extends AbstractController 
{ 
    #[Route('student/list', name: 'list1', methods: ["GET", "POST"])]
    public function list(EntityManagerInterface $entityManager, Request $request, PaginatorInterface $paginator): Response
    {
        $taskRepository = $entityManager->getRepository(Task::class);
        $query = $taskRepository->createQueryBuilder('t')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query, // Query-ul
            $request->query->getInt('page', 1), // Numărul de pagină
            10 // Numărul de elemente pe pagină
        );

        return $this->render('student/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }



    #[Route('student/view/{id}', name: 'view1')] 
    public function view(int $id, EntityManagerInterface $entityManager): Response
    {
        $task = $entityManager->getRepository(Task::class)->find($id);

        if (!$task) {
            throw $this->createNotFoundException('Sarcina nu a fost găsită');
        }

        return $this->render('student/view.html.twig', [
            'task' => $task,
        ]);
    }
    #[Route('/student', name: 'app_student1')] 
    public function index(): Response 
    { 
        return $this->render('student/index.html.twig', [ 
            'controller_name' => 'TaskController', 
        ]); 
    } 
 
    #[Route('/student/create', name: 'taskcreate')] 
    public function create(EntityManagerInterface $entityManager, Request $request): Response 
    { 
        $task = new Task(); 
        $form = $this->createForm(TaskType::class, $task); 
        $form->handleRequest($request); 
     
        if (!($form->isSubmitted() && $form->isValid())) { 
            return $this->render('student/create.html.twig', [ 
                'task_form' => $form, 
            ]); 
        } 
     
        $entityManager->persist($task); 
        $entityManager->flush(); 
     
        return $this->redirectToRoute('taskupdate', ['id' => $task->getId()]); // Redirecționați corect la ruta 'taskupdate' 
    } 
 
    #[Route('/student/update/{id}', name: 'taskupdate')] 
    public function update(int $id,TaskRepository $TaskRepository): Response 
    { 
        $task= $TaskRepository->find($id); 
    $form = $this->createForm(TaskType::class, $task); 
    return $this->render('student/create.html.twig',[ 
    'task_form' => $form, 
    ]); 
} 
 
    #[Route('/student/delete/{id}', name: 'taskdelete')] 
    public function delete(int $id, TaskRepository $taskRepository, EntityManagerInterface $entityManager): Response 
    { 
        $task = $taskRepository->find($id); 
     
        if (!$task) { 
            throw $this->createNotFoundException('Task not found'); 
        } 
     
        $entityManager->remove($task); 
        $entityManager->flush(); 
     
        return $this->redirectToRoute('taskcreate'); // Redirecționați corect la ruta 'taskcreate' 
    } 
}

