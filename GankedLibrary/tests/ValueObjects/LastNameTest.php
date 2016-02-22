<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    /**
     * @covers Ganked\Library\ValueObjects\LastName
     * @covers Ganked\Library\ValueObjects\Name
     */
    class LastNameTest extends \PHPUnit_Framework_TestCase
    {
        public function testSetAndGetWorks()
        {
            $name = new LastName('Müller');
            $this->assertSame('Müller', (string) $name);
        }

        public function testNonAlphabeticNameThrowsException()
        {
            $this->setExpectedException(\InvalidArgumentException::class);
            new LastName('1234');
        }

        public function testTooLongNameThrowsException()
        {
            $this->setExpectedException(\InvalidArgumentException::class);
            new LastName('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
        }
    }
}
