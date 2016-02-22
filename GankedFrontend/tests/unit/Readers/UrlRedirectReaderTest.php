<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Readers
{

    /**
     * @covers Ganked\Frontend\Readers\UrlRedirectReader
     */
    class UrlRedirectReaderTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var UrlRedirectReader
         */
        private $reader;
        private $fileBackend;

        protected function setUp()
        {
            $this->fileBackend = $this->getMockBuilder(\Ganked\Library\Backends\FileBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->reader = new UrlRedirectReader($this->fileBackend);
        }

        public function testHasPermanentUrlRedirectWorks()
        {
            $this->fileBackend
                ->expects($this->once())
                ->method('load')
                ->will($this->returnValue('{"/foo":"/bar"}'));

            $this->assertTrue($this->reader->hasPermanentUrlRedirect('/foo'));
            $this->assertFalse($this->reader->hasPermanentUrlRedirect('/bar'));
        }

        /**
         * @depends testHasPermanentUrlRedirectWorks
         */
        public function testGetPermanentUrlRedirectWorks()
        {
            $this->fileBackend
                ->expects($this->once())
                ->method('load')
                ->will($this->returnValue('{"/foo":"/bar"}'));

            $this->assertSame('/bar', $this->reader->getPermanentUrlRedirect('/foo'));
        }

        /**
         * @depends testHasPermanentUrlRedirectWorks
         * @expectedException \OutOfBoundsException
         */
        public function testGetInvalidPermanentUrlRedirectThrowsException()
        {
            $this->fileBackend
                ->expects($this->once())
                ->method('load')
                ->will($this->returnValue('{"/foo":"/bar"}'));

            $this->reader->getPermanentUrlRedirect('/bar');
        }
    }
}
