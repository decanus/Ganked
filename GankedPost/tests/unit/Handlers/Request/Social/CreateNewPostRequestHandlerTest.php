<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers\Request
{

    /**
     * @covers \Ganked\Post\Handlers\Request\CreateNewPostRequestHandler
     * @covers \Ganked\Post\Handlers\Request\AbstractRequestHandler
     * @covers \Ganked\Post\Handlers\AbstractHandler
     */
    class CreateNewPostRequestHandlerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var CreateNewPostRequestHandler
         */
        private $handler;
        private $session;
        private $model;
        private $request;
        private $token;
        private $sessionHasUserQuery;
        private $createNewPostCommand;

        protected function setUp()
        {
            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\PostRequest::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->model = $this->getMockBuilder(\Ganked\Post\Models\JsonModel::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->session = $this->getMockBuilder(\Ganked\Skeleton\Session\Session::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->sessionHasUserQuery = $this->getMockBuilder(\Ganked\Skeleton\Queries\SessionHasUserQuery::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->token = $this->getMockBuilder(\Ganked\Library\ValueObjects\Token::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->createNewPostCommand = $this->getMockBuilder(\Ganked\Post\Commands\CreateNewPostCommand::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->handler = new CreateNewPostRequestHandler(
                $this->session,
                $this->createNewPostCommand,
                $this->sessionHasUserQuery
            );
        }

        public function testExecuteWorks()
        {
            $this->request
                ->expects($this->at(0))
                ->method('getParameter')
                ->with('token')
                ->will($this->returnValue(1234));

            $this->session
                ->expects($this->once())
                ->method('getToken')
                ->will($this->returnValue($this->token));

            $this->token
                ->expects($this->once())
                ->method('check')
                ->with(1234)
                ->will($this->returnValue(true));

            $this->sessionHasUserQuery
                ->expects($this->once())
                ->method('execute')
                ->will($this->returnValue(true));

            $this->request
                ->expects($this->at(1))
                ->method('getParameter')
                ->with('post')
                ->will($this->returnValue('blah blah blah'));

            $this->createNewPostCommand
                ->expects($this->once())
                ->method('execute')
                ->with(
                    $this->isInstanceOf(\Ganked\Library\ValueObjects\Post::class)
                )
                ->will($this->returnValue(true));

            $this->handler->execute($this->model, $this->request);
        }

        public function testFailedCommandReturnsError()
        {
            $this->request
                ->expects($this->at(0))
                ->method('getParameter')
                ->with('token')
                ->will($this->returnValue(1234));

            $this->session
                ->expects($this->once())
                ->method('getToken')
                ->will($this->returnValue($this->token));

            $this->token
                ->expects($this->once())
                ->method('check')
                ->with(1234)
                ->will($this->returnValue(true));

            $this->sessionHasUserQuery
                ->expects($this->once())
                ->method('execute')
                ->will($this->returnValue(true));

            $this->request
                ->expects($this->at(1))
                ->method('getParameter')
                ->with('post')
                ->will($this->returnValue('blah blah blah'));

            $this->createNewPostCommand
                ->expects($this->once())
                ->method('execute')
                ->with(
                    $this->isInstanceOf(\Ganked\Library\ValueObjects\Post::class)
                )
                ->will($this->returnValue(false));

            $returnData = [
                'status' => 'error',
                'data' => [],
                'error' => 'Something went wrong please try again later'
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }

        public function testInvalidPostReturnsError()
        {
            $this->request
                ->expects($this->at(0))
                ->method('getParameter')
                ->with('token')
                ->will($this->returnValue(1234));

            $this->session
                ->expects($this->once())
                ->method('getToken')
                ->will($this->returnValue($this->token));

            $this->token
                ->expects($this->once())
                ->method('check')
                ->with(1234)
                ->will($this->returnValue(true));

            $this->sessionHasUserQuery
                ->expects($this->once())
                ->method('execute')
                ->will($this->returnValue(true));

            $this->request
                ->expects($this->at(1))
                ->method('getParameter')
                ->with('post')
                ->will(
                    $this->returnValue(
                        'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. '
                        . 'Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur  '
                        . ' ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. '
                        . 'Nulla consequat massa quis enim. Donec p'
                    )
                );

            $returnData = [
                'status' => 'error',
                'data' => [],
                'error' => 'Your post cannot contain more than 300 characters.'
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }

        public function testUsernameIssueReturnsError()
        {
            $this->request
                ->expects($this->at(0))
                ->method('getParameter')
                ->with('token')
                ->will($this->returnValue(1234));

            $this->session
                ->expects($this->once())
                ->method('getToken')
                ->will($this->returnValue($this->token));

            $this->token
                ->expects($this->once())
                ->method('check')
                ->with(1234)
                ->will($this->returnValue(true));

            $this->sessionHasUserQuery
                ->expects($this->once())
                ->method('execute')
                ->will($this->returnValue(false));

            $returnData = [
                'status' => 'error',
                'data' => [],
                'error' => 'Something went wrong, please try again later'
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }

        public function testNoUserReturnsError()
        {
            $this->request
                ->expects($this->at(0))
                ->method('getParameter')
                ->with('token')
                ->will($this->returnValue(1234));

            $this->session
                ->expects($this->once())
                ->method('getToken')
                ->will($this->returnValue($this->token));

            $this->token
                ->expects($this->once())
                ->method('check')
                ->with(1234)
                ->will($this->returnValue(true));

            $returnData = [
                'status' => 'error',
                'data' => [],
                'error' => 'Something went wrong, please try again later'
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }

        public function testInvalidCSRFReturnsError()
        {
            $this->request
                ->expects($this->at(0))
                ->method('getParameter')
                ->with('token')
                ->will($this->returnValue(1234));

            $this->session
                ->expects($this->once())
                ->method('getToken')
                ->will($this->returnValue($this->token));

            $this->token
                ->expects($this->once())
                ->method('check')
                ->with(1234)
                ->will($this->returnValue(false));

            $returnData = [
                'status' => 'error',
                'data' => [],
                'error' => 'Something went wrong, please try again later'
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }
    
    }
}
