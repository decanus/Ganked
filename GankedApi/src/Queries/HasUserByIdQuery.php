<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Queries
{
    use Ganked\API\Services\UserService;

    class HasUserByIdQuery
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
         *
         * @return bool
         */
        public function execute(\MongoId $id)
        {
            return $this->userService->getUserById($id) !== null;
        }

    }
}
