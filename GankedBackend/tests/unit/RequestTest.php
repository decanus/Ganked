<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend
{
    /**
     * @covers Ganked\Backend\Request
     */
    class RequestTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var Request
         */
        private $request;

        protected function setUp()
        {
            $this->request = new Request(['', 'task', '--foo=bar']);
        }

        public function testGetTaskWorks()
        {
            $this->assertSame('task', $this->request->getTask());
        }

        public function testHasParameterReturnsTrue()
        {
            $this->assertTrue($this->request->hasParameter('foo'));
        }

        public function testGetParameterWorks()
        {
            $this->assertSame('bar', $this->request->getParameter('foo'));
        }

        public function testGetNonExistingParameterThrowsException()
        {
            $this->setExpectedException(\Exception::class);
            $this->request->getParameter('bar');
        }
    }
}
