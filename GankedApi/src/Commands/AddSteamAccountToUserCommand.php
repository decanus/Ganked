<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\API\Commands
{

    use Ganked\API\Services\UserService;
    use Ganked\Library\ValueObjects\Steam\SteamId;

    class AddSteamAccountToUserCommand
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
         * @param \MongoId $userId
         * @param SteamId  $steamId
         * @param string   $name
         *
         * @return bool
         */
        public function execute(\MongoId $userId, SteamId $steamId, $name = '')
        {
            return $this->userService->appendSteamAccountToUser($userId, $steamId, $name);
        }
    }
}
