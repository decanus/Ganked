<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Models
{

    use Ganked\Library\ValueObjects\Steam\SteamCustomId;
    use Ganked\Library\ValueObjects\Username;
    use Ganked\Skeleton\Models\AbstractPageModel;

    class SteamRegistrationPageModel extends AbstractPageModel
    {
        /**
         * @var Username
         */
        private $username;

        /**
         * @var SteamCustomId
         */
        private $customId;

        /**
         * @param Username $username
         */
        public function setUsername(Username $username)
        {
            $this->username = $username;
        }

        /**
         * @return Username
         */
        public function getUsername()
        {
            return $this->username;
        }

        /**
         * @return bool
         */
        public function hasUsername()
        {
            return $this->username !== null;
        }

        /**
         * @param SteamCustomId $customId
         */
        public function setCustomId(SteamCustomId $customId)
        {
            $this->customId = $customId;
        }

        /**
         * @return SteamCustomId
         */
        public function getCustomId()
        {
            return $this->customId;
        }

        /**
         * @return bool
         */
        public function hasCustomId()
        {
            return $this->customId !== null;
        }
    }
}
