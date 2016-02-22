<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers\Request
{

    /**
     * @covers Ganked\Post\Handlers\Request\RegistrationRequestHandler
     * @covers Ganked\Post\Handlers\Request\AbstractRequestHandler
     * @covers Ganked\Post\Handlers\AbstractHandler
     */
    class RegistrationRequestHandlerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var RegistrationRequestHandler
         */
        private $handler;
        private $session;
        private $model;
        private $request;
        private $token;
        private $fetchAccountQuery;
        private $insertUserCommand;
        private $isVerifiedForBetaQuery;
        private $mail;

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

            $this->fetchAccountQuery = $this->getMockBuilder(\Ganked\Skeleton\Queries\FetchAccountQuery::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->insertUserCommand = $this->getMockBuilder(\Ganked\Post\Commands\InsertUserCommand::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->mail = $this->getMockBuilder(\Ganked\Post\Mails\VerifyMail::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->isVerifiedForBetaQuery = $this->getMockBuilder(\Ganked\Post\Queries\IsVerifiedForBetaQuery::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->handler = new RegistrationRequestHandler(
                $this->session,
                $this->fetchAccountQuery,
                $this->insertUserCommand,
                $this->mail,
                $this->isVerifiedForBetaQuery
            );
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
                ->will($this->returnValue('notAnEmail'));

            $returnData = [
                'status' => 'error',
                'data' => [
                    'email' => ['text' => 'Please enter a valid Email']
                ]
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }

        public function testUnapprovedEmailSetsError()
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
                ->will($this->returnValue('test@ganked.net'));

            $this->isVerifiedForBetaQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue(false));

            $returnData = [
                'status' => 'error',
                'data' => [
                    'email' => ['text' => 'This email is not approved for the beta program']
                ]
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }

        public function testAlreadyUsedEmailSetsError()
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
                ->will($this->returnValue('test@ganked.net'));

            $this->isVerifiedForBetaQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue(true));

            $this->fetchAccountQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue([]));

            $returnData = [
                'status' => 'error',
                'data' => [
                    'email' => ['text' => 'Email is already in use']
                ]
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }

        public function testInvalidUsernameSetsError()
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
                ->will($this->returnValue('test@ganked.net'));

            $this->isVerifiedForBetaQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue(true));

            $this->fetchAccountQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue(['errors' => ['code' => 404]]));

            $this->request
                ->expects($this->at(2))
                ->method('getParameter')
                ->with('username')
                ->will($this->returnValue('@inv4lid'));

            $returnData = [
                'status' => 'error',
                'data' => [
                    'username' => ['text' => 'Please ensure username only contains letters and numbers']
                ]
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }

        public function testInUseUsernameSetsError()
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
                ->will($this->returnValue('test@ganked.net'));

            $this->isVerifiedForBetaQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue(true));

            $this->fetchAccountQuery
                ->expects($this->at(0))
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue(['errors' => ['code' => 404]]));

            $this->request
                ->expects($this->at(2))
                ->method('getParameter')
                ->with('username')
                ->will($this->returnValue('elelel'));

            $this->fetchAccountQuery
                ->expects($this->at(1))
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Username::class))
                ->will($this->returnValue([]));

            $returnData = [
                'status' => 'error',
                'data' => [
                    'username' => ['text' => 'Username is already in use']
                ]
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }

        public function testInvalidNamesAndPasswordSetErrors()
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
                ->will($this->returnValue('test@ganked.net'));

            $this->isVerifiedForBetaQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue(true));

            $this->fetchAccountQuery
                ->expects($this->at(0))
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue(['errors' => ['code' => 404]]));

            $this->request
                ->expects($this->at(2))
                ->method('getParameter')
                ->with('username')
                ->will($this->returnValue('elelel'));

            $this->fetchAccountQuery
                ->expects($this->at(1))
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Username::class))
                ->will($this->returnValue(['errors' => ['code' => 404]]));

            $this->request
                ->expects($this->at(3))
                ->method('getParameter')
                ->with('firstName')
                ->will($this->returnValue('123'));

            $this->request
                ->expects($this->at(4))
                ->method('getParameter')
                ->with('lastName')
                ->will($this->returnValue('123'));

            $this->request
                ->expects($this->at(5))
                ->method('getParameter')
                ->with('password')
                ->will($this->returnValue('123'));

            $returnData = [
                'status' => 'error',
                'data' => [
                    'firstName' => ['text' => 'Please enter a valid firstname'],
                    'lastName' => ['text' => 'Please enter a valid lastname'],
                    'password' => ['text' => 'Password must contain 6 characters'],
                ]
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }

        public function testMailExceptionSetsErrorAndHandlesException()
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
                ->will($this->returnValue('test@ganked.net'));

            $this->isVerifiedForBetaQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue(true));

            $this->fetchAccountQuery
                ->expects($this->at(0))
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue(['errors' => ['code' => 404]]));

            $this->request
                ->expects($this->at(2))
                ->method('getParameter')
                ->with('username')
                ->will($this->returnValue('elelel'));

            $this->fetchAccountQuery
                ->expects($this->at(1))
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Username::class))
                ->will($this->returnValue(['errors' => ['code' => 404]]));

            $this->request
                ->expects($this->at(3))
                ->method('getParameter')
                ->with('firstName')
                ->will($this->returnValue('Hans'));

            $this->request
                ->expects($this->at(4))
                ->method('getParameter')
                ->with('lastName')
                ->will($this->returnValue('Muüller'));

            $this->request
                ->expects($this->at(5))
                ->method('getParameter')
                ->with('password')
                ->will($this->returnValue('123456'));

            $this->insertUserCommand
                ->expects($this->once())
                ->method('execute');

            $this->mail
                ->expects($this->once())
                ->method('setHash');

            $this->mail
                ->expects($this->once())
                ->method('setRecipient');

            $this->mail
                ->expects($this->once())
                ->method('send')
                ->will($this->throwException(new \Exception()));

            $returnData = [
                'status' => 'error',
                'data' => [],
                'error' => 'Failed to send verification mail, please try again later'
            ];

            $logger = $this->getMockBuilder(\Ganked\Library\Logging\Logger::class)
                ->disableOriginalConstructor()
                ->getMock();

            $logger->expects($this->once())->method('log');

            $this->handler->setLogger($logger);

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
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

            $this->request
                ->expects($this->at(1))
                ->method('getParameter')
                ->with('email')
                ->will($this->returnValue('test@ganked.net'));

            $this->isVerifiedForBetaQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue(true));

            $this->fetchAccountQuery
                ->expects($this->at(0))
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue(['errors' => ['code' => 404]]));

            $this->request
                ->expects($this->at(2))
                ->method('getParameter')
                ->with('username')
                ->will($this->returnValue('elelel'));

            $this->fetchAccountQuery
                ->expects($this->at(1))
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Username::class))
                ->will($this->returnValue(['errors' => ['code' => 404]]));

            $this->request
                ->expects($this->at(3))
                ->method('getParameter')
                ->with('firstName')
                ->will($this->returnValue('Hans'));

            $this->request
                ->expects($this->at(4))
                ->method('getParameter')
                ->with('lastName')
                ->will($this->returnValue('Muüller'));

            $this->request
                ->expects($this->at(5))
                ->method('getParameter')
                ->with('password')
                ->will($this->returnValue('123456'));

            $this->insertUserCommand
                ->expects($this->once())
                ->method('execute');

            $this->mail
                ->expects($this->once())
                ->method('setHash');

            $this->mail
                ->expects($this->once())
                ->method('setRecipient');

            $this->mail
                ->expects($this->once())
                ->method('send');

            $returnData = [
                'status' => 'success',
                'data' => [
                    'text' => 'Successfully registered, verification mail has been sent to test@ganked.net'
                ]
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }

    }
}
