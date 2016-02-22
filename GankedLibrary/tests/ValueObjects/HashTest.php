<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    /**
     * @covers Ganked\Library\ValueObjects\Hash
     */
    class HashTest extends \PHPUnit_Framework_TestCase
    {
        public function testSetAndGetWorks()
        {
            $hash = new Hash('1234', 'a');
            $this->assertTrue(strlen($hash) === 64);
        }
    }
}
