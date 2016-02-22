<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Commands
{
    use Ganked\Library\DataPool\RedisBackend;
    use Ganked\Library\ValueObjects\Token;

    class DeleteAccessTokenCommand
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
         * @param Token $token
         */
        public function execute(Token $token)
        {
            $this->redisBackend->hDel('accessToken', (string) $token);
        }
    }
}
