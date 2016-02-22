<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Queries
{
    use Ganked\API\Services\UserService;
    use Ganked\Library\ValueObjects\Email;

    class FetchAccountWithEmailQuery
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
         * @param Email $email
         *
         * @return array|null
         */
        public function execute(Email $email)
        {
            return $this->userService->getAccountWithEmail($email);
        }
    }
}
