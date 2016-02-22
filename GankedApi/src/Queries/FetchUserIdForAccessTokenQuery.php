<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Queries
{
    use Ganked\Library\DataPool\RedisBackend;
    use Ganked\Library\ValueObjects\Token;

    class FetchUserIdForAccessTokenQuery
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
         *
         * @return string
         * @throws \InvalidArgumentException
         */
        public function execute(Token $token)
        {
            if (!$this->redisBackend->hHas('accessToken', (string) $token)) {
                throw new \InvalidArgumentException('Invalid access token', 401);
            }

            return $this->redisBackend->hGet('accessToken', (string) $token);
        }
    }
}
