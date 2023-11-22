<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCreateUser(): void
    {
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setPassword('password');

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('test@example.com', $user->getEmail());
        $this->assertSame('password', $user->getPassword());
    }

    public function testRoles(): void
    {
        $user = new User();
        $this->assertContains('ROLE_USER', $user->getRoles());

        $user->setRoles(['ROLE_ADMIN']);
        $this->assertContains('ROLE_USER', $user->getRoles());
        $this->assertContains('ROLE_ADMIN', $user->getRoles());
    }

    public function testEraseCredentials(): void
    {
        $user = new User();
        $user->eraseCredentials();
        $this->expectNotToPerformAssertions();
    }
}
