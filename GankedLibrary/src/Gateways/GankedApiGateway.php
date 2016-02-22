<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Gateways
{

    use Ganked\Library\ValueObjects\Post;
    use Ganked\Library\ValueObjects\Steam\SteamId;
    use Ganked\Library\ValueObjects\UserId;
    use Ganked\Library\ValueObjects\Username;

    class GankedApiGateway extends AbstractApiGateway
    {

        /**
         * @param Username $username
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function getUserWithUsername(Username $username)
        {
            return $this->get('/users/' . (string) $username, ['api_key' => $this->getApiKey()]);
        }

        /**
         * @param UserId $userId
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function getUserWithUserId(UserId $userId)
        {
            return $this->get('/users/' . (string) $userId, ['api_key' => $this->getApiKey()]);
        }

        /**
         * @param SteamId $steamId
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function getUserWithSteamId(SteamId $steamId)
        {
            return $this->get('/users/' . (string) $steamId, ['api_key' => $this->getApiKey()]);
        }

        /**
         * @param Username $username
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function getUserPostsByUsername(Username $username)
        {
            return $this->get('/users/' . (string) $username . '/posts', ['api_key' => $this->getApiKey()]);
        }

        /**
         * @param string $account
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function getAccount($account)
        {
            return $this->get('/accounts/' . (string) $account, ['api_key' => $this->getApiKey()]);
        }

        /**
         * @param UserId $userId
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function getPostsFromUser(UserId $userId)
        {
            return $this->get('/users/' . $userId . '/posts', ['api_key' => $this->getApiKey()]);
        }

        /**
         * @param string $user
         * @param string $password
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function authenticate($user, $password)
        {
            return $this->post(
                '/authenticate',
                ['api_key' => $this->getApiKey(), 'user' => $user, 'password' => $password]
            );
        }

        /**
         * @param array $user
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function createNewUser(array $user)
        {
            $user['api_key'] = $this->getApiKey();
            return $this->post('/users', $user);
        }

        /**
         * @param UserId  $userId
         * @param SteamId $steamId
         * @param string  $name
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function connectSteamAccountToUser(UserId $userId, SteamId $steamId, $name = '')
        {
            return $this->post(
                '/users/' . (string) $userId . '/steamId',
                ['steamId' => (string) $steamId, 'steamName' => $name, 'api_key' => $this->getApiKey()]
            );
        }

        /**
         * @param Post   $post
         * @param UserId $userId
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function createNewPost(Post $post, UserId $userId)
        {
            return $this->post('/posts', ['message' => (string) $post, 'userId' => $userId, 'api_key' => $this->getApiKey()]);
        }
    }
}
