<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Http\Request
{
    /**
     * @covers Ganked\Skeleton\Http\Request\PostRequest
     * @covers Ganked\Skeleton\Http\Request\GetRequest
     * @covers Ganked\Skeleton\Http\Request\AbstractRequest
     */
    class PostRequestTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var PostRequest
         */
        private $request;

        private $parameters;
        private $server;
        private $cookies;

        protected function setUp()
        {
            $this->cookies = ['cookie' => 'bar'];
            $this->server = [
                'HTTP_REFERER' => 'ganked.test',
                'HTTP_HOST' => 'ganked.test',
                'HTTP_USER_AGENT' => 'not ie',
                'REMOTE_ADDR' => 'sweg',
                'REQUEST_URI' => '/'
            ];
            $this->parameters = ['foo' => 'bar'];

            $this->request = new PostRequest($this->parameters, $this->server, $this->cookies);
        }

        public function testGetUriWorks()
        {
            $this->assertInstanceOf(\Ganked\Library\ValueObjects\Uri::class, $this->request->getUri());
        }

        public function testGetUserIpWorks()
        {
            $this->assertSame($this->server['REMOTE_ADDR'], $this->request->getUserIP());
        }

        public function testGetUserAgentWorks()
        {
            $this->assertSame($this->server['HTTP_USER_AGENT'], $this->request->getUserAgent());
        }

        public function testGetHostWorks()
        {
            $this->assertSame($this->server['HTTP_HOST'], $this->request->getHost());
        }

        public function testGetRefererWorks()
        {
            $this->assertSame($this->server['HTTP_REFERER'], $this->request->getReferer());
        }

        public function testHasAndGetCookieWorks()
        {
            $this->assertTrue($this->request->hasCookieParameter('cookie'));
            $this->assertSame($this->cookies['cookie'], $this->request->getCookieParameter('cookie'));
        }

        public function testNonExistingCookieThrowsException()
        {
            $this->setExpectedException(\Exception::class);
            $this->request->getCookieParameter('bro');
        }

        public function testHasAndGetServerParameterWorks()
        {
            $this->assertTrue($this->request->hasServerParameter('REMOTE_ADDR'));
            $this->assertSame($this->server['REMOTE_ADDR'], $this->request->getServerParameter('REMOTE_ADDR'));
        }

        public function testNonExistingServerParameterThrowsException()
        {
            $this->setExpectedException(\Exception::class);
            $this->request->getServerParameter('bro');
        }

        public function testHasAndGetParameterWorks()
        {
            $this->assertTrue($this->request->hasParameter('foo'));
            $this->assertSame($this->parameters['foo'], $this->request->getParameter('foo'));
        }

        public function testNonExistingParameterThrowsException()
        {
            $this->setExpectedException(\Exception::class);
            $this->request->getParameter('bro');
        }

        public function testGetParametersWorks()
        {
            $this->assertSame($this->parameters, $this->request->getParameters());
        }

        public function testRemoveCookieParameterWorks()
        {
            $this->assertTrue($this->request->hasCookieParameter('cookie'));
            $this->request->removeCookieParameter('cookie');
            $this->assertFalse($this->request->hasCookieParameter('cookie'));
        }
    }
}
