<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    /**
     * @covers Ganked\Library\ValueObjects\FirstName
     * @covers Ganked\Library\ValueObjects\Name
     */
    class FirstNameTest extends \PHPUnit_Framework_TestCase
    {
        public function testSetAndGetWorks()
        {
            $name = new FirstName('bob');
            $this->assertSame('Bob', (string) $name);
        }

        public function testNonAlphabeticNameThrowsException()
        {
            $this->setExpectedException(\InvalidArgumentException::class);
            new FirstName('1234');
        }

        public function testTooLongNameThrowsException()
        {
            $this->setExpectedException(\InvalidArgumentException::class);
            new FirstName('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
        }
    }
}
