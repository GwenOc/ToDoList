<?php

namespace App\tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{

    private $user;

    public function setUp()
    {
        $this->user = new User();
    }

    public function testGetId()
    {
        $this->assertEquals(null, $this->user->getId());
    }

    public function testGetUsername()
    {
        $this->user->setUsername('batman');
        static::assertSame('batman', $this->user->getUsername());
    }

    public function testGetPassword()
    {
        $this->user->setPassword('Robin');
        static::assertSame('Robin', $this->user->getPassword());
    }

    public function testGetEmail()
    {
        $this->user->setEmail('batman@email.com');
        static::assertSame('batman@email.com', $this->user->getEmail());
    }

    public function testGetRoles()
    {
        $this->user->setRoles(['ROLE_USER']);
        static::assertSame(['ROLE_USER'], $this->user->getRoles());
    }

    public function testGetSalt()
    {
        static::assertSame(null, $this->user->getSalt());
    }

    public function testEraseCredential()
    {
        static::assertSame(null, $this->user->eraseCredentials());
    }
}
