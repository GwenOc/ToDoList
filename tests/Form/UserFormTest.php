<?php

namespace App\tests\Form;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Test\TypeTestCase;

class UserFormTest extends TypeTestCase
{
    public function testForm()
    {
        $formData = [
            'username' => 'Batman',
            'password' => [
                'first' => 'Robin',
                'second' => 'Robin',
            ],
            'email' => 'batman@gmail.com',
            'roles' => ['ROLE_USER'],
        ];

        $object = new User();
        $objectToCompare = new User();
        $object->setUsername('Batman');
        $object->setPassword('Robin');
        $object->setEmail('batman@gmail.com');

        $form = $this->factory->create(UserType::class, $objectToCompare);
        $form->submit($formData);
        $this->assertTrue($form->isSubmitted());
        $this->assertTrue($form->isValid());
        $this->assertEquals($object, $objectToCompare);
        $this->assertInstanceOf(User::class, $form->getData());
        $view = $form->createView();
        $children = $view->children;
        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}