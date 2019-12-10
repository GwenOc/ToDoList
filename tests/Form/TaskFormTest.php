<?php

namespace App\tests\Form;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskFormTest extends TypeTestCase
{
    public function testForm()
    {
        $formData = [
            'title' => 'Ecrire des tests',
            'content' => 'Rédiger tous les tests',
        ];

        $datetime = new \DateTime();

        $object = new Task();
        $objectToCompare = new Task();
        $objectToCompare->setCreatedAt($datetime);

        $object->setContent('Rédiger tous les tests');
        $object->setTitle('Ecrire des tests');
        $object->setCreatedAt($datetime);

        $form = $this->factory->create(TaskType::class, $objectToCompare);
        $form->submit($formData);

        $this->assertTrue($form->isSubmitted());
        $this->assertTrue($form->isValid());
        $this->assertEquals($object, $objectToCompare);
        $this->assertInstanceOf(Task::class, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}