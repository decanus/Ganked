<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Models
{

    class SummonerRunesPageModel extends AbstractSummonerModel
    {
        /**
         * @var array
         */
        private $runes;


        /**
         * @param array $runes
         */
        public function setRunes(array $runes = [])
        {
            $this->runes = $runes;
        }

        /**
         * @return array
         */
        public function getRunes()
        {
            return $this->runes;
        }
    }
}
