<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Controllers
{
    /**
     * @covers Ganked\Skeleton\Controllers\JsonErrorPageController
     * @covers Ganked\Skeleton\Controllers\AbstractPageController
     * @uses Ganked\Skeleton\Http\Request\AbstractRequest
     */
    class JsonErrorControllerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var JsonErrorPageController
         */
        private $controller;
        private $model;
        private $response;
        private $request;

        protected function setUp()
        {
            $this->response = $this->getMockBuilder(\Ganked\Skeleton\Http\Response\JsonResponse::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->model = $this->getMockBuilder(\Ganked\Skeleton\Models\JsonErrorPageModel::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\GetRequest::class)
                ->disableOriginalClone()
                ->getMock();

            $this->controller = new JsonErrorPageController(
                $this->response,
                $this->model
            );
        }

        public function testExecuteWorks()
        {
            $this->model
                ->expects($this->exactly(2))
                ->method('getResponseCode')
                ->will($this->returnValue(500));

            $this->response
                ->expects($this->once())
                ->method('setStatusCode')
                ->with($this->isInstanceOf(\Ganked\Skeleton\Http\StatusCodes\InternalServerError::class));

            $this->model
                ->expects($this->once())
                ->method('getContent')
                ->will($this->returnValue([]));

            $this->controller->execute($this->request);

        }
    }
}
