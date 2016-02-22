<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Commands
{
    use Ganked\Library\DataPool\RedisBackend;
    use Ganked\Library\ValueObjects\Token;

    class SaveAccessTokenCommand
    {
        /**
         * @var RedisBackend
         */
        private $redisBackend;

        /**
         * @param RedisBackend $redisBackend
         */
        public function __construct(RedisBackend $redisBackend)
        {
            $this->redisBackend = $redisBackend;
        }

        /**
         * @param Token  $token
         * @param string $userId
         */
        public function execute(Token $token, $userId)
        {
            $this->redisBackend->hSet('accessToken', (string) $token, $userId);
        }
    }
}
