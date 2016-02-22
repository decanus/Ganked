<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Post\AccessToken
{
    /**
     * @covers Ganked\API\Handlers\Post\AccessToken\CommandHandler
     * @uses \Ganked\API\Exceptions\ApiException
     */
    class CommandHandlerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var CommandHandler
         */
        private $handler;
        private $request;
        private $model;
        private $saveAccessTokenCommand;

        protected function setUp()
        {
            $this->saveAccessTokenCommand = $this->getMockBuilder(\Ganked\API\Commands\SaveAccessTokenCommand::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\PostRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->model = $this->getMockBuilder(\Ganked\API\Models\ApiModel::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->handler = new CommandHandler($this->saveAccessTokenCommand);
        }

        /**
         * @expectedException \Ganked\API\Exceptions\ApiException
         */
        public function testMissingRequestParametersThrowsException()
        {
            $this->request
                ->expects($this->once())
                ->method('hasParameter')
                ->with('userId')
                ->will($this->returnValue(false));

            $this->handler->execute($this->request, $this->model);
        }

        public function testExecuteWorks()
        {
            $this->request
                ->expects($this->once())
                ->method('hasParameter')
                ->with('userId')
                ->will($this->returnValue(true));

            $this->request
                ->expects($this->once())
                ->method('getParameter')
                ->with('userId')
                ->will($this->returnValue('foobar'));

            $this->saveAccessTokenCommand
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Token::class), 'foobar');

            $this->model
                ->expects($this->once())
                ->method('setData');

            $this->handler->execute($this->request, $this->model);
        }


    }
}
