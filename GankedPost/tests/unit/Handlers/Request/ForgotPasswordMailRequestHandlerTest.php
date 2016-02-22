<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers\Request
{

    /**
     * @covers Ganked\Post\Handlers\Request\ForgotPasswordMailRequestHandler
     * @covers Ganked\Post\Handlers\Request\AbstractRequestHandler
     * @covers Ganked\Post\Handlers\AbstractHandler
     */
    class ForgotPasswordMailRequestHandlerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var ForgotPasswordMailRequestHandler
         */
        private $handler;
        private $session;
        private $fetchUserHashQuery;
        private $forgotPasswordMail;
        private $fetchAccountQuery;
        private $model;
        private $request;
        private $token;

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

            $this->token = $this->getMockBuilder(\Ganked\Library\ValueObjects\Token::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->fetchUserHashQuery = $this->getMockBuilder(\Ganked\Skeleton\Queries\FetchUserHashQuery::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->forgotPasswordMail = $this->getMockBuilder(\Ganked\Post\Mails\ForgotPasswordMail::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->fetchAccountQuery = $this->getMockBuilder(\Ganked\Skeleton\Queries\FetchAccountQuery::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->handler = new ForgotPasswordMailRequestHandler(
                $this->session,
                $this->fetchUserHashQuery,
                $this->fetchAccountQuery,
                $this->forgotPasswordMail
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

            $email = 'test@test.net';
            $this->request
                ->expects($this->at(1))
                ->method('getParameter')
                ->with('email')
                ->will($this->returnValue($email));

            $this->fetchAccountQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue(['bleh']));

            $hash = '1234';
            $this->fetchUserHashQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue($hash));

            $this->forgotPasswordMail
                ->expects($this->once())
                ->method('setHash')
                ->with($hash);

            $this->forgotPasswordMail
                ->expects($this->once())
                ->method('setEmail')
                ->with($email);

            $this->forgotPasswordMail
                ->expects($this->once())
                ->method('send');

            $this->handler->execute($this->model, $this->request);
        }

        public function testMailSendExceptionIsLogged()
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

            $email = 'test@test.net';
            $this->request
                ->expects($this->at(1))
                ->method('getParameter')
                ->with('email')
                ->will($this->returnValue($email));

            $this->fetchAccountQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue(['bleh']));

            $hash = '1234';
            $this->fetchUserHashQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue($hash));

            $this->forgotPasswordMail
                ->expects($this->once())
                ->method('setHash')
                ->with($hash);

            $this->forgotPasswordMail
                ->expects($this->once())
                ->method('setEmail')
                ->with($email);

            $logger = $this->getMockBuilder(\Ganked\Library\Logging\Loggers\LoggerInterface::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->handler->setLogger($logger);

            $this->forgotPasswordMail
                ->expects($this->once())
                ->method('send')
                ->will($this->throwException(new \Exception('boom')));

            $logger->expects($this->once())->method('log');

            $this->handler->execute($this->model, $this->request);
        }

        public function testNonExistingUserSetsError()
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

            $email = 'test@test.net';
            $this->request
                ->expects($this->at(1))
                ->method('getParameter')
                ->with('email')
                ->will($this->returnValue($email));

            $this->fetchAccountQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue(['errors' => 'foo']));

            $returnData = [
                'status' => 'error',
                'data' => [
                    'email' => ['text' => 'Please enter a valid email']
                ]
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }

        public function testInvalidEmailSetsError()
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

            $this->request
                ->expects($this->at(1))
                ->method('getParameter')
                ->with('email')
                ->will($this->returnValue('bleh'));

            $returnData = [
                'status' => 'error',
                'data' => [
                    'email' => ['text' => 'Please enter a valid email']
                ]
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }

    }
}
