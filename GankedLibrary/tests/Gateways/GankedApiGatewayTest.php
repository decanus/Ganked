<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Gateways
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Library\ValueObjects\UserId;
    use Ganked\Library\ValueObjects\Username;

    /**
     * @covers Ganked\Library\Gateways\GankedApiGateway
     * @covers Ganked\Library\Gateways\AbstractApiGateway
     * @covers Ganked\Library\ValueObjects\Uri
     * @covers Ganked\Library\ValueObjects\Username
     */
    class GankedApiGatewayTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var GankedApiGateway
         */
        private $gateway;
        private $curl;
        private $apiUri;
        private $apiToken;

        protected function setUp()
        {
            $this->curl = $this->getMockBuilder(\Ganked\Library\Curl\Curl::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->apiUri = new Uri('http://api.ganked.net');
            $this->apiToken = '123';

            $this->gateway = new GankedApiGateway($this->curl, $this->apiUri, $this->apiToken);
        }

        public function testGetAccountWorks()
        {
            $account = 'foo';

            $this->curl
                ->expects($this->once())
                ->method('get')
                ->with(new Uri((string) $this->apiUri . '/accounts/' . $account, ['api_key' => $this->apiToken]));

            $this->gateway->getAccount($account);
        }

        public function testGetUserWithUsernameWorks()
        {
            $username = new Username('azulio');

            $this->curl
                ->expects($this->once())
                ->method('get')
                ->with(new Uri((string) $this->apiUri . '/users/' . $username, ['api_key' => $this->apiToken]));

            $this->gateway->getUserWithUsername($username);
        }

        public function testGetUserWithUserIdWorks()
        {
            $id = new UserId('566e890509edfe77108b4567');

            $this->curl
                ->expects($this->once())
                ->method('get')
                ->with(new Uri((string) $this->apiUri . '/users/' . $id, ['api_key' => $this->apiToken]));

            $this->gateway->getUserWithUserId($id);
        }

        public function testAuthenticateWorks()
        {
            $user = 'foo';
            $password = 'foo';

            $this->curl
                ->expects($this->once())
                ->method('post')
                ->with(
                    new Uri((string) $this->apiUri . '/authenticate',
                    ['api_key' => $this->apiToken, 'user' => $user, 'password' => $password])
                );

            $this->gateway->authenticate($user, $password);
        }

        public function testGetUserPostsByUsernameWorks()
        {
            $username = new Username('azulio');

            $this->curl
                ->expects($this->once())
                ->method('get')
                ->with(new Uri((string) $this->apiUri . '/users/' . $username . '/posts', ['api_key' => $this->apiToken]));

            $this->gateway->getUserPostsByUsername($username);
        }

        public function testCreateNewUserWorks()
        {
            $user = ['foo' => 'bar'];
            $submit = $user;
            $submit['api_key'] = $this->apiToken;

            $this->curl
                ->expects($this->once())
                ->method('post')
                ->with(new Uri((string) $this->apiUri . '/users', $submit));

            $this->gateway->createNewUser($user);
        }

        public function testGetPostsFromUserWorks()
        {
            $userId = new UserId;

            $submit['api_key'] = $this->apiToken;

            $this->curl
                ->expects($this->once())
                ->method('get')
                ->with(new Uri((string) $this->apiUri . '/users/' . $userId . '/posts', ['api_key' => $this->apiToken]));

            $this->gateway->getPostsFromUser($userId);
        }
    }
}
