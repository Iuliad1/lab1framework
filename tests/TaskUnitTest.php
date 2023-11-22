<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testSetTitle(): void
    {
        $task = new Task();
        $task->setTitle('Test Title');

        $this->assertEquals('Test Title', $task->getTitle());
    }

    public function testSetDescription(): void
    {
        $task = new Task();
        $task->setDescription('Test Description');

        $this->assertEquals('Test Description', $task->getDescription());
    }

    public function testSetCreatedAt(): void
    {
        // Folosim o dată fixă pentru a evita erorile de timp
        $createdAt = new \DateTime('2023-01-01 12:00:00');
        $task = new Task();
        $task->setCreatedAt($createdAt);

        $this->assertEquals($createdAt, $task->getCreatedAt());
    }

    public function testSetCategory(): void
    {
        // Creăm un mock pentru clasa Category
        $category = $this->createMock(Category::class);
    
        $task = new Task();
        $task->setCategory($category);
    
        $this->assertInstanceOf(Category::class, $task->getCategory());
    }
}