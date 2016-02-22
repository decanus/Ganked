<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Mappers
{

    use Ganked\Frontend\DataObjects\Profile;
    use Ganked\Frontend\Queries\Social\FetchProfileForUsernameQuery;
    use Ganked\Frontend\Queries\Social\HasProfileForUsernameQuery;
    use Ganked\Library\ValueObjects\Username;

    class UserProfileMapper
    {
        /**
         * @var HasProfileForUsernameQuery
         */
        private $hasProfileForUsernameQuery;

        /**
         * @var FetchProfileForUsernameQuery
         */
        private $fetchProfileForUsernameQuery;

        /**
         * @param HasProfileForUsernameQuery $hasProfileForUsernameQuery
         * @param FetchProfileForUsernameQuery $fetchProfileForUsernameQuery
         */
        public function __construct(
            HasProfileForUsernameQuery $hasProfileForUsernameQuery,
            FetchProfileForUsernameQuery $fetchProfileForUsernameQuery
        )
        {
            $this->hasProfileForUsernameQuery = $hasProfileForUsernameQuery;
            $this->fetchProfileForUsernameQuery = $fetchProfileForUsernameQuery;
        }

        /**
         * @param $username
         * @return Profile
         */
        public function map($username)
        {
            try {
                $username = new Username($username);
            } catch (\InvalidArgumentException $e) {
                return;
            }

            if (!$this->hasProfileForUsernameQuery->execute($username)) {
                return;
            }

            $profile = new Profile;
            $profile->setUsername($username);
            return $profile;
        }
    }
}
