<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers\Request
{

    /**
     * @covers Ganked\Post\Handlers\Request\PasswordRecoveryRequestHandler
     * @covers Ganked\Post\Handlers\Request\AbstractRequestHandler
     * @covers Ganked\Post\Handlers\AbstractHandler
     */
    class PasswordRecoveryRequestHandlerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var PasswordRecoveryRequestHandler
         */
        private $handler;
        private $session;
        private $model;
        private $request;
        private $token;
        private $fetchUserHashQuery;
        private $updateUserHashCommand;
        private $updateUserPasswordCommand;
        private $fetchAccountQuery;

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

            $this->updateUserHashCommand = $this->getMockBuilder(\Ganked\Post\Commands\UpdateUserHashCommand::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->updateUserPasswordCommand = $this->getMockBuilder(\Ganked\Post\Commands\UpdateUserPasswordCommand::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->fetchAccountQuery = $this->getMockBuilder(\Ganked\Skeleton\Queries\FetchAccountQuery::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->handler = new PasswordRecoveryRequestHandler(
                $this->session,
                $this->fetchUserHashQuery,
                $this->updateUserHashCommand,
                $this->updateUserPasswordCommand,
                $this->fetchAccountQuery
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

            $email = 'test@ganked.net';

            $this->request
                ->expects($this->at(1))
                ->method('getParameter')
                ->with('email')
                ->will($this->returnValue($email));

            $hash = '1234';
            $this->request
                ->expects($this->at(2))
                ->method('getParameter')
                ->with('hash')
                ->will($this->returnValue($hash));

            $this->request
                ->expects($this->at(3))
                ->method('getParameter')
                ->with('newPassword')
                ->will($this->returnValue('password'));

            $this->fetchUserHashQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue($hash));

            $this->fetchAccountQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue(['data' => ['attributes' => ['salt' => '1234']]]));

            $this->updateUserPasswordCommand
                ->expects($this->once())
                ->method('execute')
                ->with(
                    $this->isInstanceOf(\Ganked\Library\ValueObjects\Hash::class),
                    $this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class)
                );

            $this->request
                ->expects($this->at(4))
                ->method('getUserIP')
                ->will($this->returnValue('123.123.123'));

            $this->request
                ->expects($this->at(5))
                ->method('getUserAgent')
                ->will($this->returnValue('sweg'));

            $this->updateUserHashCommand
                ->expects($this->once())
                ->method('execute');

            $returnData = [
                'status' => 'success',
                'data' => [
                    'text' => 'Password has been changed, you can now login'
                ]
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }

        public function testCommandExceptionSetsError()
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

            $email = 'test@ganked.net';

            $this->request
                ->expects($this->at(1))
                ->method('getParameter')
                ->with('email')
                ->will($this->returnValue($email));

            $hash = '1234';
            $this->request
                ->expects($this->at(2))
                ->method('getParameter')
                ->with('hash')
                ->will($this->returnValue($hash));

            $this->request
                ->expects($this->at(3))
                ->method('getParameter')
                ->with('newPassword')
                ->will($this->returnValue('password'));

            $this->fetchUserHashQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue($hash));

            $this->fetchAccountQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->throwException(new \Exception('boom')));

            $returnData = [
                'status' => 'error',
                'data' => [],
                'error' => 'Something went wrong, Please try again later'
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }

        public function testNonMatchingHashesSetsError()
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

            $email = 'test@ganked.net';

            $this->request
                ->expects($this->at(1))
                ->method('getParameter')
                ->with('email')
                ->will($this->returnValue($email));

            $this->request
                ->expects($this->at(2))
                ->method('getParameter')
                ->with('hash')
                ->will($this->returnValue('1234'));

            $this->request
                ->expects($this->at(3))
                ->method('getParameter')
                ->with('newPassword')
                ->will($this->returnValue('password'));

            $this->fetchUserHashQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue('123'));

            $returnData = [
                'status' => 'error',
                'data' => [],
                'error' => 'Something went wrong, Please try again later'
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }

        public function testInvalidPasswordSetsError()
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

            $email = 'test@ganked.net';

            $this->request
                ->expects($this->at(1))
                ->method('getParameter')
                ->with('email')
                ->will($this->returnValue($email));

            $this->request
                ->expects($this->at(2))
                ->method('getParameter')
                ->with('hash')
                ->will($this->returnValue('1234'));

            $this->request
                ->expects($this->at(3))
                ->method('getParameter')
                ->with('newPassword')
                ->will($this->returnValue('12345'));

            $returnData = [
                'status' => 'error',
                'data' => [
                    'newPassword' => ['text' => 'Password must contain 6 characters']
                ],
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
                'data' => [],
                'error' => 'It looks like you used an invalid link. Please request another email'
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }
    }
}
