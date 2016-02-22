<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Delete\AccessToken
{

    /**
     * @covers Ganked\API\Handlers\Delete\AccessToken\CommandHandler
     * @uses \Ganked\API\Exceptions\ApiException
     */
    class CommandHandlerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var CommandHandler
         */
        private $handler;
        private $deleteAccessTokenCommand;
        private $request;
        private $model;

        protected function setUp()
        {
            $this->request = $this->getMockBuilder(\Ganked\Api\Http\Request\DeleteRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->model = $this->getMockBuilder(\Ganked\API\Models\ApiModel::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->deleteAccessTokenCommand = $this->getMockBuilder(\Ganked\API\Commands\DeleteAccessTokenCommand::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->handler = new CommandHandler($this->deleteAccessTokenCommand);
        }

        /**
         * @expectedException \Ganked\API\Exceptions\ApiException
         */
        public function testMissingParameterThrowsException()
        {
            $this->request
                ->expects($this->once())
                ->method('hasParameter')
                ->with('access_token')
                ->will($this->returnValue(false));

            $this->handler->execute($this->request, $this->model);
        }

        public function testExecuteWorks()
        {
            $this->request
                ->expects($this->once())
                ->method('hasParameter')
                ->with('access_token')
                ->will($this->returnValue(true));

            $this->request
                ->expects($this->once())
                ->method('getParameter')
                ->with('access_token')
                ->will($this->returnValue('123 456'));

            $this->deleteAccessTokenCommand
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Token::class));

            $this->model
                ->expects($this->once())
                ->method('setData')
                ->with(['success' => true]);

            $this->handler->execute($this->request, $this->model);
        }
    }
}
