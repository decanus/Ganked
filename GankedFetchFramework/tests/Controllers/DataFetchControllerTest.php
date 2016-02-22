<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Fetch\Controllers
{
    /**
     * @covers Ganked\Fetch\Controllers\DataFetchController
     */
    class DataFetchControllerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var DataFetchController
         */
        private $controller;
        private $dataFetchHandler;
        private $request;
        private $cookie;
        private $response;

        protected function setUp()
        {
            $this->dataFetchHandler = $this->getMockBuilder(\Ganked\Fetch\Handlers\DataFetch\DataFetchHandlerInterface::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\GetRequest::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->cookie = $this->getMockBuilder(\Ganked\Library\ValueObjects\Cookie::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->response = $this->getMockBuilder(\Ganked\Skeleton\Http\Response\JsonResponse::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->controller = new DataFetchController(
                $this->response,
                $this->dataFetchHandler
            );
        }

        public function testExecuteWorks()
        {
            $this->dataFetchHandler
                ->expects($this->once())
                ->method('execute')
                ->with($this->request)
                ->will($this->returnValue(['foo' => 'bar']));

            $this->assertSame(
                $this->response,
                $this->controller->execute($this->request)
            );
        }
    }
}
