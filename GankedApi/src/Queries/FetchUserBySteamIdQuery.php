<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\API\Queries
{

    use Ganked\API\Services\UserService;
    use Ganked\Library\ValueObjects\Steam\SteamId;

    class FetchUserBySteamIdQuery
    {
        /**
         * @var UserService
         */
        private $userService;

        /**
         * @param UserService $userService
         */
        public function __construct(UserService $userService)
        {
            $this->userService = $userService;
        }

        /**
         * @param SteamId $steamId
         * @param array   $fields
         *
         * @return array|null
         */
        public function execute(SteamId $steamId, array $fields = [])
        {
            return $this->userService->getUserBySteamId($steamId, $fields);
        }
    }
}
