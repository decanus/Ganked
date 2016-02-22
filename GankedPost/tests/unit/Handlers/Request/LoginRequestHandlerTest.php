<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers\Request
{
    /**
     * @covers Ganked\Post\Handlers\Request\LoginRequestHandler
     * @covers Ganked\Post\Handlers\Request\AbstractRequestHandler
     * @covers Ganked\Post\Handlers\AbstractHandler
     */
    class LoginRequestHandlerTest extends \PHPUnit_Framework_TestCase
    {
        private $handler;
        private $session;
        private $fetchUserByIdQuery;
        private $loginUserCommand;
        private $authenticationCommand;
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

            $this->fetchUserByIdQuery = $this->getMockBuilder(\Ganked\Skeleton\Queries\FetchUserByIdQuery::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->loginUserCommand = $this->getMockBuilder(\Ganked\Post\Commands\LoginUserCommand::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->authenticationCommand = $this->getMockBuilder(\Ganked\Post\Commands\AuthenticationCommand::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->handler = new LoginRequestHandler(
                $this->session,
                $this->loginUserCommand,
                $this->authenticationCommand,
                $this->fetchUserByIdQuery
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
                ->will($this->returnValue('asbd@'));

            $returnData = [
                'status' => 'error',
                'data' => [
                    'email' => ['text' => 'Please enter a valid email or username']
                ]
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }

        public function testUnverifiedUserSetsError()
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

            $this->request
                ->expects($this->at(2))
                ->method('getParameter')
                ->with('password')
                ->will($this->returnValue('test123'));

            $data = ['data' => ['attributes' => ['user' => '566e890509edfe77108b4567']]];

            $this->authenticationCommand
                ->expects($this->once())
                ->method('execute')
                ->with('test@ganked.net', 'test123')
                ->will($this->returnValue($data));

            $curlResponse = $this->getMockBuilder(\Ganked\Library\Curl\Response::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->fetchUserByIdQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\UserId::class))
                ->will($this->returnValue($curlResponse));

            $curlResponse->expects($this->once())->method('getResponseCode')->will($this->returnValue(200));

            $curlResponse
                ->expects($this->once())
                ->method('getDecodedJsonResponse')
                ->will($this->returnValue(
                    [ 'data' =>
                        [
                            'id' => 'yay',
                            'attributes' => [
                                'verified' => 0,
                                'password' => 'f4c2178860817a2c25d2cb3185aa25779b0ecaf17c30845926218e17a18a9f89',
                                'salt' => '123',
                                'username' => 'ganked',
                                'email' => 'yay@yaya.ch',
                            ]
                        ]
                    ]
                ));

            $returnData = [
                'status' => 'error',
                'data' => [
                    'email' => [
                        'text' => 'Please verify your account <a href="/account/resend-verification?email=yay@yaya.ch">Resend verification email</a>'
                    ]
                ]
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }


        public function testLoginWorks()
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
                ->will($this->returnValue('test'));

            $this->request
                ->expects($this->at(2))
                ->method('getParameter')
                ->with('password')
                ->will($this->returnValue('test123'));

            $data = ['data' => ['attributes' => ['user' => '566e890509edfe77108b4567']]];

            $this->authenticationCommand
                ->expects($this->once())
                ->method('execute')
                ->with('test', 'test123')
                ->will($this->returnValue($data));

            $curlResponse = $this->getMockBuilder(\Ganked\Library\Curl\Response::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->fetchUserByIdQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\UserId::class))
                ->will($this->returnValue($curlResponse));

            $curlResponse->expects($this->once())->method('getResponseCode')->will($this->returnValue(200));

            $curlResponse
                ->expects($this->once())
                ->method('getDecodedJsonResponse')
                ->will($this->returnValue(
                    [ 'data' =>
                        [
                            'id' => 'yay',
                            'attributes' => [
                                'verified' => 1,
                                'password' => 'f4c2178860817a2c25d2cb3185aa25779b0ecaf17c30845926218e17a18a9f89',
                                'salt' => '123',
                                'username' => 'ganked',
                                'email' => 'yay@yaya.ch',
                            ]
                        ]
                    ]
                ));

            $this->loginUserCommand
                ->expects($this->once())
                ->method('execute')
                ->with(
                    $this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class),
                    $this->isInstanceOf(\Ganked\Library\ValueObjects\Username::class),
                    'yay'
                );

            $sessionData = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->session
                ->expects($this->exactly(2))
                ->method('getSessionData')
                ->will($this->returnValue($sessionData));

            $sessionData->expects($this->once())->method('hasPreviousUri')->will($this->returnValue(true));
            $sessionData->expects($this->once())->method('getPreviousUri')->will($this->returnValue('http://ganked.test'));

            $returnData = [
                'status' => 'success',
                'data' => [
                    'redirect' => 'http://ganked.test',
                    'text' => 'Successfully logged in'
                ]
            ];

            $this->assertSame($returnData, $this->handler->execute($this->model, $this->request));
        }
    
    }
}
