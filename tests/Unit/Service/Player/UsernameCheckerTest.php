<?php

namespace App\Tests\Unit\Service\Player;

use App\Service\Player\UsernameChecker;
use PHPUnit\Framework\TestCase;

class UsernameCheckerTest extends TestCase
{
    public function test_is_valid(): void
    {
        $usernameChecker = new UsernameChecker();

        $this->assertTrue($usernameChecker->isValid('Howdie'));
        $this->assertTrue($usernameChecker->isValid('HOWDIE'));
        $this->assertTrue($usernameChecker->isValid('Howdie2'));
        $this->assertTrue($usernameChecker->isValid('Howdie-2'));
        $this->assertFalse($usernameChecker->isValid('Howdie😊'));
        $this->assertFalse($usernameChecker->isValid('Howdie-😊'));
        $this->assertFalse($usernameChecker->isValid('2HOWDIE'));
        $this->assertFalse($usernameChecker->isValid('HOWDIE_'));
    }
}