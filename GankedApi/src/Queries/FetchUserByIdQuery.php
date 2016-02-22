<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Queries
{
    use Ganked\API\Services\UserService;

    class FetchUserByIdQuery
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
         * @param array    $fields
         *
         * @return array|null
         */
        public function execute(\MongoId $id, $fields = [])
        {
            return $this->userService->getUserById($id, $fields);
        }
    }
}
