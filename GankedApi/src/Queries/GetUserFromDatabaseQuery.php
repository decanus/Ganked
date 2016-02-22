<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Queries
{
    use Ganked\API\Services\UserService;
    use Ganked\Library\ValueObjects\Username;

    class GetUserFromDatabaseQuery
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
         * @param array    $fields
         *
         * @return array
         */
        public function execute(Username $username, $fields = [])
        {
            return $this->userService->getUserByUsername($username, $fields);
        }
    }
}
