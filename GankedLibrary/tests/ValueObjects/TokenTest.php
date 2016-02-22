<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    /**
     * @covers Ganked\Library\ValueObjects\Token
     */
    class TokenTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var Token
         */
        private $token;

        protected function setUp()
        {
             $this->token = new Token('1234');
        }

        public function testTokenToStringWorks()
        {
            $this->assertSame('1234', (string) $this->token);
        }

        public function testTokenCheckWorks()
        {
            $this->assertTrue($this->token->check('1234'));
        }

        public function testTokenGenerateWorks()
        {
            $this->token = new Token();
            $this->assertNotEmpty((string) $this->token);
        }
    }
}
