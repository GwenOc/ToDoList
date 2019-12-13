<?php

namespace App\tests\UnitTests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $user = new User();
        $username = 'Batman';
        $email = 'batman@gmail.com';
        $password = 'Robin';
        $role = ['ROLE_USER'];
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRoles($role);

        $this->assertEquals(null, $user->getId());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($username, $user->getUsername());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals(null, $user->getSalt());
        $this->assertEquals($role, $user->getRoles());

    }
}
