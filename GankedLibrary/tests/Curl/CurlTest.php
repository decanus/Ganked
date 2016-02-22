<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Curl
{

    use Ganked\Library\ValueObjects\Uri;

    /**
     * @covers Ganked\Library\Curl\Curl
     */
    class CurlTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var Curl
         */
        private $curl;
        private $curlHandler;
        private $curlMultiHandler;
        private $response;

        protected function setUp()
        {
            $this->curlHandler = $this->getMockBuilder(\Ganked\Library\Curl\CurlHandler::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->curlMultiHandler = $this->getMockBuilder(\Ganked\Library\Curl\CurlMultiHandler::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->response = $this->getMockBuilder(\Ganked\Library\Curl\Response::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->curl = new Curl($this->curlHandler, $this->curlMultiHandler);
        }

        /**
         * @dataProvider dataProvider
         */
        public function testCurlWorks($method, $requestType, $uri, $params)
        {
            $this->curlHandler
                ->expects($this->once())
                ->method('sendRequest')
                ->with($requestType, $uri, $params)
                ->will($this->returnValue($this->response));

            $this->assertSame($this->response, $this->curl->{$method}($uri, $params));
        }

        public function dataProvider()
        {
            return [
                ['get', 'GET', new Uri('http://www.ganked.net'), ['foo' => 'bar']],
                ['post', 'POST', new Uri('http://www.ganked.net'), ['foo' => 'bar']],
                ['patch', 'PATCH', new Uri('http://www.ganked.net'), ['foo' => 'bar']],
                ['delete', 'DELETE', new Uri('http://www.ganked.net'), ['foo' => 'bar']],
            ];
        }
    }
}
