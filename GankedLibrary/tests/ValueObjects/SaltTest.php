<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    /**
     * @covers Ganked\Library\ValueObjects\Salt
     */
    class SaltTest extends \PHPUnit_Framework_TestCase
    {
        public function testSetAndGetWorks()
        {
            $salt = new Salt();
            $this->assertTrue(strlen($salt) === 32);
        }
    }
}
