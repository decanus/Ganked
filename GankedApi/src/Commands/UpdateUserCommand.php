<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Commands
{
    use Ganked\API\Services\UserService;

    class UpdateUserCommand
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
         * @param \MongoId $id
         * @param array    $updates
         *
         * @return bool
         */
        public function execute(\MongoId $id, array $updates)
        {
            return $this->userService->updateUser($id, $updates);
        }
    }
}
