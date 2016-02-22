<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Controllers
{

    /**
     * @covers Ganked\API\Controllers\ErrorController
     */
    class ErrorControllerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var ErrorController
         */
        private $controller;
        private $response;
        private $request;

        protected function setUp()
        {
            $this->response = $this->getMockBuilder(\Ganked\Skeleton\Http\Response\AbstractResponse::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\GetRequest::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->controller = new ErrorController($this->response);
        }

        public function testExecuteWorks()
        {
            $this->request
                ->expects($this->once())
                ->method('getServerParameter')
                ->with('REQUEST_METHOD')
                ->will($this->returnValue('GET'));

            $this->controller->execute($this->request);
        }
    }
}
