<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\DataPool
{

    class LeagueOfLegendsDataPoolWriter extends AbstractDataPool
    {
        /**
         * @param string $id
         * @param string $data
         */
        public function setRune($id, $data)
        {
            $this->getBackend()->hSet('lol:runes', $id, $data);
        }

        /**
         * @param string $id
         * @param string $data
         */
        public function setItem($id, $data)
        {
            $this->getBackend()->hSet('lol:items', $id, $data);
        }

        /**
         * @param string $id
         * @param string $data
         */
        public function setSummonerSpell($id, $data)
        {
            $this->getBackend()->hSet('lol:spells', $id, $data);
        }
    }
}
