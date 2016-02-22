<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Commands
{
    use Ganked\API\Services\UserService;

    class InsertUserCommand
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
         * @param array $user
         *
         * @return array|null
         * @throws \Exception
         */
        public function execute(array $user)
        {
            return $this->userService->createNewUser($user);
        }
    }
}
