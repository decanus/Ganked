<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Backends\Wrappers
{
    /**
     * @covers Ganked\Skeleton\Backends\Wrappers\CurlResponse
     */
    class CurlResponseTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var CurlResponse
         */
        private $response;

        protected function setUp()
        {
            $this->response = new CurlResponse();
        }

        public function testSetAndGetHttpStatusWorks()
        {
            $this->response->setHttpStatus(200);
            $this->assertSame(200, $this->response->getHttpStatus());
        }

        public function testSetAndGetBodyWorks()
        {
            $this->response->setBody('body');
            $this->assertSame('body', $this->response->getBody());
        }

        public function testSetAndGetContentTypeWorks()
        {
            $this->response->setContentType('application/json');
            $this->assertSame('application/json', $this->response->getContentType());
        }
    }
}
