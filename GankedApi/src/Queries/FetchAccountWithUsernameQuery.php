<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Queries
{
    use Ganked\API\Services\UserService;
    use Ganked\Library\ValueObjects\Username;

    class FetchAccountWithUsernameQuery
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
         * @param Username $username
         *
         * @return array|null
         */
        public function execute(Username $username)
        {
            return $this->userService->getAccountWithUsername($username);
        }
    }
}
