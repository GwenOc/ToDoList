<?php

namespace App\tests\UnitTests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskUnitTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $task = new Task();
        $titre = 'aller chasser les méchants';
        $content = 'Faire regner l\'ordre et la justice ce soir au plus tard';
        $createdAt = new \DateTime();
        $user = new User();

        $task->setTitle($titre);
        $task->setContent($content);
        $task->setCreatedAt($createdAt);
        $task->setUser($user);

        $this->assertEquals(null, $task->getId());
        $this->assertEquals($titre, $task->getTitle());
        $this->assertEquals($content, $task->getContent());
        $this->assertEquals($createdAt, $task->getCreatedAt());
        $this->assertEquals($user, $task->getUser());
        $this->assertEquals(false, $task->isDone());
    }
}