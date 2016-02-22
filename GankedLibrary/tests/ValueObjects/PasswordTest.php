<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    /**
     * @covers Ganked\Library\ValueObjects\Password
     */
    class PasswordTest extends \PHPUnit_Framework_TestCase
    {
        public function testShortPasswordThrowsException()
        {
            $this->setExpectedException(\InvalidArgumentException::class);
            new Password('123');
        }

        public function testConstructWithValidPasswordWorks()
        {
            $password = new Password('123456');
            $this->assertSame('123456', (string) $password);
        }
    }
}
