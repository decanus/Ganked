<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers\Redirect
{

    /**
     * @covers Ganked\Post\Handlers\Redirect\LogoutRedirectHandler
     * @covers \Ganked\Post\Handlers\Redirect\AbstractRedirectHandler
     * @covers \Ganked\Post\Handlers\AbstractHandler
     */
    class LogoutRedirectHandlerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var LogoutRedirectHandler
         */
        private $handler;
        private $sessionData;
        private $request;
        private $model;
        private $destroySessionCommand;

        protected function setUp()
        {
            $this->sessionData = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\PostRequest::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->model = $this->getMockBuilder(\Ganked\Post\Models\JsonModel::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->destroySessionCommand = $this->getMockBuilder(\Ganked\Skeleton\Commands\DestroySessionCommand::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->handler = new LogoutRedirectHandler(false, $this->sessionData, $this->destroySessionCommand);
        }

        public function testExecuteWorks()
        {
            $token = $this->getMockBuilder(\Ganked\Library\ValueObjects\Token::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->sessionData
                ->expects($this->once())
                ->method('getToken')
                ->will($this->returnValue($token));
            $this->request
                ->expects($this->once())
                ->method('getParameter')
                ->will($this->returnValue('foo'));
            $token->expects($this->once())->method('check')->with('foo')->will($this->returnValue('true'));

            $this->sessionData
                ->expects($this->once())
                ->method('removeAccount');
            $this->destroySessionCommand
                ->expects($this->once())
                ->method('execute')
                ->with($this->request);

            $this->sessionData
                ->expects($this->once())
                ->method('hasPreviousUri')
                ->will($this->returnValue(true));
            $this->sessionData
                ->expects($this->once())
                ->method('getPreviousUri')
                ->will($this->returnValue('http://ganked.test'));

            $this->model
                ->expects($this->once())
                ->method('setRedirectUri');

            $this->handler->execute($this->model, $this->request);
        }

        public function testExecuteWorksWithoutPreviousUri()
        {
            $token = $this->getMockBuilder(\Ganked\Library\ValueObjects\Token::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->sessionData
                ->expects($this->once())
                ->method('getToken')
                ->will($this->returnValue($token));
            $this->request
                ->expects($this->once())
                ->method('getParameter')
                ->will($this->returnValue('foo'));
            $token->expects($this->once())->method('check')->with('foo')->will($this->returnValue('true'));

            $this->sessionData
                ->expects($this->once())
                ->method('removeAccount');

            $this->destroySessionCommand
                ->expects($this->once())
                ->method('execute')
                ->with($this->request);

            $this->sessionData
                ->expects($this->once())
                ->method('hasPreviousUri')
                ->will($this->returnValue(false));

            $this->model
                ->expects($this->once())
                ->method('setRedirectUri');

            $this->handler->execute($this->model, $this->request);
        }
    }
}
