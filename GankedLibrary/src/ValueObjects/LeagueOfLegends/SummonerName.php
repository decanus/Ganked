<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects\LeagueOfLegends
{
    class SummonerName 
    {
        /**
         * @var string
         */
        private $summonerName;

        /**
         * @param string $summonerName
         *
         * @throws \InvalidArgumentException
         */
        public function __construct($summonerName)
        {
            $this->validateName($summonerName);
            $this->summonerName = $summonerName;
        }

        /**
         * @param string $summonerName
         *
         * @throws \InvalidArgumentException
         */
        private function validateName($summonerName)
        {
            $length = strlen($summonerName);
            if (strspn($summonerName, ',/;[]\-=`<>?:"{}|_+~!@#$%^&*()') !== 0 || $length < 2 || $length > 23) {
                throw new \InvalidArgumentException('"' . $summonerName . '" is not a valid name');
            }
        }

        /**
         * @return string
         */
        public function getSummonerNameForLink()
        {
            return htmlspecialchars(strtolower(urlencode(str_replace(' ', '', $this->summonerName))));
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return $this->summonerName;
        }
    }
}
