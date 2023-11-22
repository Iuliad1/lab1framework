<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaskFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setTitle("test_category");
        $manager->persist($category); // Adaugă categoria în managerul de obiecte

        $task = new Task();
        $task->setTitle("test task");
        $task->setCategory($category);
        $task->setCreatedAt(new \DateTime()); // Corectează pentru a seta data de creare (createdAt)
        $manager->persist($task); 

        $manager->flush();
    }
}
