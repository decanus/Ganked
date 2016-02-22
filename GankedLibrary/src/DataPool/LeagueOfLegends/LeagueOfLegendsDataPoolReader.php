<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\DataPool
{

    use Ganked\Library\Helpers\DomHelper;

    class LeagueOfLegendsDataPoolReader extends AbstractDataPool
    {
        /**
         * @param string $id
         *
         * @return bool
         */
        public function hasRune($id)
        {
            return $this->getBackend()->hHas('lol:runes', $id);
        }

        /**
         * @param string $id
         *
         * @return array
         * @throws \InvalidArgumentException
         */
        public function getRune($id)
        {
            if (!$this->hasRune($id)) {
                throw new \InvalidArgumentException('Rune "' . $id . '" does not exist');
            }

            return json_decode($this->getBackend()->hGet('lol:runes', $id), true);
        }

        /**
         * @param string $name
         *
         * @return array
         * @throws \OutOfBoundsException
         */
        public function getChampionByName($name)
        {
            if (!$this->getBackend()->hHas('lol:champions:data', $name)) {
                throw new \OutOfBoundsException('Champion "' . $name . '" not found');
            }

            return json_decode($this->getBackend()->hGet('lol:champions:data', $name), true);
        }

        /**
         * @param string $id
         *
         * @return bool
         */
        public function hasChampionById($id)
        {
            return $this->getBackend()->hHas('lol:champions:list', $id);
        }

        /**
         * @param string $id
         *
         * @return string
         * @throws \OutOfBoundsException
         */
        public function getChampionById($id)
        {
            if (!$this->hasChampionById($id)) {
                throw new \OutOfBoundsException('Champion for id "' . $id . '" not found');
            }

            return $this->getBackend()->hGet('lol:champions:list', $id);
        }

        /**
         * @param string $id
         *
         * @return array
         * @throws \OutOfBoundsException
         */
        public function getChampionDataById($id)
        {
            return $this->getChampionByName($this->getChampionById($id));
        }

        /**
         * @return DomHelper
         */
        public function getLeagueOfLegendsMasteriesTemplate()
        {
            return new DomHelper($this->getBackend()->get('lol:masteries:template'));
        }

        /**
         * @param string $id
         *
         * @return bool
         */
        public function hasItem($id)
        {
            return $this->getBackend()->hHas('lol:items', $id);
        }

        /**
         * @param string $id
         *
         * @return array
         * @throws \InvalidArgumentException
         */
        public function getItem($id)
        {
            if (!$this->hasItem($id)) {
                throw new \InvalidArgumentException('Item "' . $id . '" does not exist');
            }

            return json_decode($this->getBackend()->hGet('lol:items', $id), true);
        }

        /**
         * @param string $id
         *
         * @return bool
         */
        public function hasSpell($id)
        {
            return $this->getBackend()->hHas('lol:spells', $id);
        }

        /**
         * @param string $id
         *
         * @return array
         * @throws \InvalidArgumentException
         */
        public function getSpell($id)
        {
            if (!$this->hasSpell($id)) {
                throw new \InvalidArgumentException('Spell "' . $id . '" does not exist');
            }

            return json_decode($this->getBackend()->hGet('lol:spells', $id), true);
        }
    }
}
