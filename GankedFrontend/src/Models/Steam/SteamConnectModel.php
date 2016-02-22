<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Models
{

    use Ganked\Library\ValueObjects\Steam\SteamId;
    use Ganked\Skeleton\Models\AbstractPageModel;

    class SteamConnectModel extends AbstractPageModel
    {
        /**
         * @var SteamId
         */
        private $claimedId;

        /**
         * @var bool
         */
        private $isAlreadyInUse = false;

        /**
         * @param SteamId $steamId
         */
        public function setClaimedId(SteamId $steamId)
        {
            $this->claimedId = $steamId;
        }

        /**
         * @return SteamId
         */
        public function getClaimedId()
        {
            return $this->claimedId;
        }

        /**
         * @return bool
         */
        public function hasClaimedId()
        {
            return $this->claimedId !== null;
        }

        public function claimedIdHasAlreadyBeenUsed()
        {
            $this->isAlreadyInUse = true;
        }

        /**
         * @return bool
         */
        public function isAlreadyInUse()
        {
            return $this->isAlreadyInUse;
        }
    }
}
