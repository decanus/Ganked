<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Backends
{
    /**
     * @covers Ganked\Library\Backends\FileBackend
     */
    class FileBackendTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var FileBackend
         */
        private $backend;

        /**
         * @var string
         */
        private $dirName;

        protected function setUp()
        {
            $this->dirName = sys_get_temp_dir() . '/' . uniqid('test') . '/';
            $this->backend = new FileBackend();
        }

        public function testOpenNotExistingFileThrowsException()
        {
            $this->setExpectedException(\Exception::class);
            $this->backend->load(__DIR__ . '/file/doesnt/exist');
        }

        public function testOpenFileWorks()
        {
            $this->assertSame(
                file_get_contents(__DIR__ . '/../../build.xml'),
                $this->backend->load(__DIR__ . '/../../build.xml')
            );
        }

        public function testExistsWorks()
        {
            $this->assertTrue($this->backend->exists(__DIR__ . '/../../build.xml'));
            $this->assertFalse($this->backend->exists(__DIR__ . '/../data/ConfgurationTest.ini'));
        }
    }
}
