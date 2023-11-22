<?php
namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class TaskTests extends TestCase
{
    public function testTaskCategoryRelationship(): void
    {
        $category = new Category();
        $category->setName('Test Category');

        $task = new Task();
        $task->setTitle('Test Task');
        $task->setCategory($category);

        $this->assertSame($category, $task->getCategory());
        $this->assertSame('Test Task', $task->getTitle());
        $this->assertSame('Test Category', $task->getCategory()->getName());
    }
}
