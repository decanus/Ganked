<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Http\Response
{
    /**
     * @covers Ganked\Skeleton\Http\Response\HtmlResponse
     * @covers Ganked\Skeleton\Http\Response\JsonResponse
     * @covers Ganked\Skeleton\Http\Response\AbstractResponse
     */
    class HtmlResponseTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var HtmlResponse
         */
        private $response;

        protected function setUp()
        {
            $this->response = new HtmlResponse;
        }

        public function testSetAndGetCookieWorks()
        {
            $cookie = $this->getMockBuilder(\Ganked\Library\ValueObjects\Cookie::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->response->setCookie($cookie);
            $cookies = $this->response->getCookies();
            $this->assertSame($cookie, $cookies[0]);
        }

        public function testSetAndGetHeaderWorks()
        {
            $this->response->setHeader('foo', 'bar');
            $this->assertSame('bar', $this->response->getHeaders()['foo']);
        }

        public function testSetAndGetBodyWorks()
        {
            $body = 'hehe';
            $this->response->setBody($body);
            $this->assertSame($body, $this->response->getBody());
        }
    }
}
