<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers\Redirect
{

    /**
     * @covers Ganked\Post\Handlers\Redirect\VerificationRedirectHandler
     * @covers Ganked\Post\Handlers\Redirect\AbstractRedirectHandler
     * @covers Ganked\Post\Handlers\AbstractHandler
     */
    class VerificationRedirectHandlerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var VerificationRedirectHandler
         */
        private $handler;
        private $verifyUserCommand;
        private $fetchUserHashQuery;
        private $updateUserHashCommand;
        private $model;
        private $request;

        protected function setUp()
        {
            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\PostRequest::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->model = $this->getMockBuilder(\Ganked\Post\Models\JsonModel::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->verifyUserCommand = $this->getMockBuilder(\Ganked\Post\Commands\VerifyUserCommand::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->fetchUserHashQuery = $this->getMockBuilder(\Ganked\Skeleton\Queries\FetchUserHashQuery::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->updateUserHashCommand = $this->getMockBuilder(\Ganked\Post\Commands\UpdateUserHashCommand::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->handler = new VerificationRedirectHandler(
                false,
                $this->verifyUserCommand,
                $this->fetchUserHashQuery,
                $this->updateUserHashCommand
            );

        }

        public function testExecuteWorks()
        {
            $this->request
                ->expects($this->at(0))
                ->method('getParameter')
                ->with('email')
                ->will($this->returnValue('test@ganked.net'));

            $hash = '1234';

            $this->fetchUserHashQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue($hash));

            $this->request
                ->expects($this->at(1))
                ->method('getParameter')
                ->with('hash')
                ->will($this->returnValue($hash));

            $this->verifyUserCommand
                ->expects($this->once())
                ->method('execute');

            $this->model
                ->expects($this->once())
                ->method('setRedirectUri')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Uri::class));

            $this->handler->execute($this->model, $this->request);
        }

        public function testInvalidHashThrowsExceptionAndIsLogged()
        {
            $logger = $this->getMockBuilder(\Ganked\Library\Logging\Logger::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->handler->setLogger($logger);

            $this->request
                ->expects($this->at(0))
                ->method('getParameter')
                ->with('email')
                ->will($this->returnValue('test@ganked.net'));

            $hash = '1234';

            $this->fetchUserHashQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue($hash));

            $this->request
                ->expects($this->at(1))
                ->method('getParameter')
                ->with('hash')
                ->will($this->returnValue('134'));

            $logger->expects($this->once())->method('log');

            $this->model
                ->expects($this->once())
                ->method('setRedirectUri')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Uri::class));

            $this->handler->execute($this->model, $this->request);
        }
    }
}
