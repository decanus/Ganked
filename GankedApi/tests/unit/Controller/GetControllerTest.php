<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Controllers
{

    use Ganked\API\Exceptions\ApiException;
    use Ganked\Skeleton\Http\StatusCodes\InternalServerError;

    /**
     * @covers Ganked\API\Controllers\GetController
     * @covers Ganked\API\Controllers\AbstractApiController
     * @uses Ganked\API\Exceptions\ApiException
     */
    class GetControllerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var GetController
         */
        private $controller;
        private $model;
        private $preHandler;
        private $queryHandler;
        private $commandHandler;
        private $responseHandler;
        private $request;
        private $response;

        protected function setUp()
        {
            $this->model = $this->getMockBuilder(\Ganked\API\Models\ApiModel::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->response = $this->getMockBuilder(\Ganked\Skeleton\Http\Response\JsonResponse::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\GetRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->preHandler = $this->getMockBuilder(\Ganked\API\Handlers\PreHandler::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->queryHandler = $this->getMockBuilder(\Ganked\API\Handlers\QueryHandlerInterface::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->commandHandler = $this->getMockBuilder(\Ganked\API\Handlers\CommandHandlerInterface::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->responseHandler = $this->getMockBuilder(\Ganked\API\Handlers\ResponseHandler::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->controller = new GetController(
                $this->response,
                $this->model,
                $this->preHandler,
                $this->queryHandler,
                $this->commandHandler,
                $this->responseHandler
            );
        }

        public function testExecuteWorks()
        {
            $this->preHandler
                ->expects($this->once())
                ->method('execute')
                ->with($this->request);

            $exception = new ApiException('foo', 123, null, new InternalServerError);
            $this->queryHandler
                ->expects($this->once())
                ->method('execute')
                ->with($this->request, $this->model);

            $this->commandHandler
                ->expects($this->once())
                ->method('execute')
                ->with($this->request, $this->model)
                ->will($this->throwException($exception));

            $this->model
                ->expects($this->once())
                ->method('setException')
                ->with($exception);

            $this->responseHandler
                ->expects($this->once())
                ->method('execute')
                ->with($this->model);

            $this->controller->execute($this->request);
        }
    }
}
