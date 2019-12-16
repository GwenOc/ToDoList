<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


/**
 * @codeCoverageIgnore
 */
class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 9; ++$i) {
            $task = new Task();
            $task->setTitle('Tâche n°' . $i);
            $task->setContent('Ceci est la tâche n°' . $i);
            $user = $this->getReference('user' . mt_rand(1, 9));
            $task->setUser($user);
            $manager->persist($task);
        }
        $task = new Task();
        $task->setTitle('Tâche anonyme');
        $task->setContent('Ceci est la tâche anonyme');
        $manager->persist($task);
        $manager->flush();
    }
    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
