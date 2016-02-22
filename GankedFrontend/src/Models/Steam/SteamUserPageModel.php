<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Models
{

    use Ganked\Frontend\DataObjects\CounterStrike\User;
    use Ganked\Skeleton\Models\AbstractPageModel;

    class SteamUserPageModel extends AbstractPageModel
    {
        /**
         * @var User
         */
        private $user;

        /**
         * @var array
         */
        private $bans = [];

        /**
         * @param User $user
         */
        public function setUser(User $user)
        {
            $this->user = $user;
        }

        /**
         * @return User
         */
        public function getUser()
        {
            return $this->user;
        }

        /**
         * @param array $bans
         */
        public function setBans(array $bans = [])
        {
            $this->bans = $bans;
        }

        /**
         * @return array
         */
        public function getBans()
        {
            return $this->bans;
        }
    }
}
