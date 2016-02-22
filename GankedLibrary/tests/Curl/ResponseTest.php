<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Curl
{

    /**
     * @covers Ganked\Library\Curl\Response
     * @uses \Ganked\Library\Helpers\DomHelper
     */
    class ResponseTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var Response
         */
        private $response;

        protected function setUp()
        {
            $this->response = new Response;
        }

        public function testSetAndGetResponseCodeWorks()
        {
            $this->response->setResponseCode(200);
            $this->assertSame(200, $this->response->getResponseCode());
        }

        public function testGetDecodedJsonResponseReturnsExpectedValue()
        {
            $data = ['foo' => 'bar'];
            $this->response->setResponseBody(json_encode($data));
            $this->assertSame($data, $this->response->getDecodedJsonResponse());
        }

        public function testGetResponseAsDomHelperReturnsExpectedValue()
        {
            $body = '<div />';
            $this->response->setResponseBody($body);
            $this->assertInstanceOf(\Ganked\Library\Helpers\DomHelper::class, $this->response->getResponseAsDomHelper());
        }

    }
}
