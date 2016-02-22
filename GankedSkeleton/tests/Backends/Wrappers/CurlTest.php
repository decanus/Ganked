<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Backends\Wrappers
{

    use Ganked\Library\ValueObjects\Uri;

    /**
     * @covers Ganked\Skeleton\Backends\Wrappers\Curl
     * @uses Ganked\Skeleton\Backends\Wrappers\CurlResponse
     */
    class CurlTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var Curl
         */
        private $curl;

        protected function setUp()
        {
            $this->curl = new Curl();
        }

        /**
         * @large
         */
        public function testPostWorks()
        {
            $data = ['foo' => 'bar'];

            $response = $this->curl->post(new Uri('http://httpbin.org/post'), $data)->execute();
            $this->assertInstanceOf(CurlResponse::class, $response);

            $this->assertSame($data, json_decode($response->getBody(), true)['form']);
        }

        /**
         * @large
         */
        public function testGetWorks()
        {
            $data = ['foo' => 'bar'];

            $response = $this->curl->get(new Uri('http://httpbin.org/get'), $data, [])->execute();

            $this->assertInstanceOf(CurlResponse::class, $response);
            $this->assertSame($data, json_decode($response->getBody(), true)['args']);
        }
    }
}
