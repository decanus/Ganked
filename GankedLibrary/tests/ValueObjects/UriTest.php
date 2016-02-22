<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    /**
     * @covers Ganked\Library\ValueObjects\Uri
     */
    class UriTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var Uri
         */
        private $uri;

        protected function setUp()
        {
            $this->uri = new Uri('http://ganked.net');
        }

        public function testGetHostWorks()
        {
            $this->assertSame('ganked.net', $this->uri->getHost());
        }

        public function testGetPathWorks()
        {
            $uri = new Uri('http://ganked.net/home');
            $this->assertSame('/home', $uri->getPath());
        }

        public function testToStringWorks()
        {
            $this->assertSame('http://ganked.net', (string) $this->uri);
        }

        public function testGetPortWork()
        {
            $uri = new Uri('ganked.net:8080');
            $this->assertSame(':8080', $uri->getPort());
        }

        public function testGetQueryWorks()
        {
            $query = '?test=yup';
            $uri = new Uri('ganked.net' . $query);
            $this->assertSame($query, $uri->getQuery());
        }

        public function testGetQueryWorksForParametersWithoutValue()
        {
            $uri = new Uri('ganked.net?test&foo=bar');
            $this->assertSame('?test&foo=bar', $uri->getQuery());
        }

        public function testGetParameterWorks()
        {
            $uri =  new Uri('ganked.net?foo=bar');
            $this->assertSame('bar', $uri->getParameter('foo'));
        }
    }
}
