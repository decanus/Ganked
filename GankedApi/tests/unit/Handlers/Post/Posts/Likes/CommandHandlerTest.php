<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Post\Posts\Likes
{
    /**
     * @covers Ganked\API\Handlers\Post\Posts\Likes\CommandHandler
     */
    class CommandHandlerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var CommandHandler
         */
        private $commandHandler;
        private $likePostCommand;
        private $request;
        private $model;
        private $uri;

        protected function setUp()
        {
            $this->likePostCommand = $this->getMockBuilder(\Ganked\API\Commands\LikePostCommand::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\PostRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->model = $this->getMockBuilder(\Ganked\API\Models\ApiPostModel::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->commandHandler = new CommandHandler(
                $this->likePostCommand
            );
        }

        public function testExecuteWorks()
        {
            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $postId = '123412341234123412341234';
            $this->uri
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue('/posts/' . $postId . '/likes'));

            $userId = '123';
            $this->model
                ->expects($this->once())
                ->method('getUserId')
                ->will($this->returnValue($userId));
            $this->likePostCommand
                ->expects($this->once())
                ->method('execute')
                ->with($userId, $postId);

            $this->commandHandler->execute($this->request, $this->model);
        }
    }
}
