<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{

    /**
     * @covers Ganked\Library\ValueObjects\Email
     */
    class EmailTest extends \PHPUnit_Framework_TestCase
    {
        public function testConstructWithValidEmailWorks()
        {
            $emailString = 'webmaster@ganked.net';
            $email = new Email($emailString);
            $this->assertSame($emailString, (string) $email);
        }

        public function testInvalidEmailThrowsException()
        {
            $this->setExpectedException(\InvalidArgumentException::class);
            new Email('notValid');
        }
    }
}
