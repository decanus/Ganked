<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers
{

    /**
     * @covers Ganked\API\Handlers\PreHandler
     * @uses \Ganked\API\Exceptions\ApiException
     */
    class PreHandlerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var PreHandler
         */
        private $preHandler;
        private $tokenReader;
        private $request;

        protected function setUp()
        {
            $this->tokenReader = $this->getMockBuilder(\Ganked\API\Readers\TokenReader::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\GetRequest::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->preHandler = new PreHandler($this->tokenReader);
        }

        /**
         * @expectedException \Ganked\API\Exceptions\ApiException
         */
        public function testRequestWithoutApiKeyTriggersException()
        {
            $this->request
                ->expects($this->once())
                ->method('hasParameter')
                ->with('api_key')
                ->will($this->returnValue(false));

            $this->preHandler->execute($this->request);
        }

        /**
         * @expectedException \Ganked\API\Exceptions\ApiException
         */
        public function testTokenReaderWithWrongApiKeyTriggersException()
        {
            $this->request
                ->expects($this->once())
                ->method('hasParameter')
                ->with('api_key')
                ->will($this->returnValue(true));

            $this->request
                ->expects($this->once())
                ->method('getParameter')
                ->with('api_key')
                ->will($this->returnValue('123'));

            $this->tokenReader
                ->expects($this->once())
                ->method('hasToken')
                ->with('123')
                ->will($this->returnValue(false));

            $this->preHandler->execute($this->request);
        }
    }
}
