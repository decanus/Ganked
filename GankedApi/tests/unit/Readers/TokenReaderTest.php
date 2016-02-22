<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Readers
{

    /**
     * @covers Ganked\API\Readers\TokenReader
     */
    class TokenReaderTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var TokenReader
         */
        private $tokenReader;
        private $fileBackend;

        protected function setUp()
        {
            $this->fileBackend = $this->getMockBuilder(\Ganked\Library\Backends\FileBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->tokenReader = new TokenReader($this->fileBackend);
        }

        public function testHasTokenReturnsExpectedBool()
        {
            $this->fileBackend
                ->expects($this->once())
                ->method('load')
                ->will($this->returnValue(json_encode(['123' => 'bleg'])));

            $this->assertTrue($this->tokenReader->hasToken('123'));
            $this->assertFalse($this->tokenReader->hasToken('1243'));
        }

    }
}
