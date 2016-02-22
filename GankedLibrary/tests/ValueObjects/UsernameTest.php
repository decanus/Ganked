<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    /**
     * @covers Ganked\Library\ValueObjects\Username
     */
    class UsernameTest extends \PHPUnit_Framework_TestCase
    {
        public function testSetNonAlphaNumericUsernameThrowsException()
        {
            $this->setExpectedException(\InvalidArgumentException::class);
            new Username('*£eadc');
        }

        public function testSetAndGetWorks()
        {
            $username = new Username('ganked');
            $this->assertSame('ganked', (string) $username);
        }
    }
}
