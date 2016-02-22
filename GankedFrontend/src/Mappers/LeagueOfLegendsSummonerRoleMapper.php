<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Mappers
{

    use Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader;

    class LeagueOfLegendsSummonerRoleMapper
    {
        /**
         * @var LeagueOfLegendsDataPoolReader
         */
        private $leagueOfLegendsDataPoolReader;

        /**
         * @var array
         */
        private $positions = [
            1 => 'TOP',
            2 => 'MIDDLE',
            3 => 'JUNGLE',
            4 => 'BOT'
        ];

        /**
         * @var array
         */
        private $roles = [
            1 => 'DUO',
            2 => 'SUPPORT',
            3 => 'CARRY',
            4 => 'SOLO'
        ];

        /**
         * @param LeagueOfLegendsDataPoolReader $leagueOfLegendsDataPoolReader
         */
        public function __construct(LeagueOfLegendsDataPoolReader $leagueOfLegendsDataPoolReader)
        {
            $this->leagueOfLegendsDataPoolReader = $leagueOfLegendsDataPoolReader;
        }

        /**
         * @param int $position
         *
         * @return string
         * @throws \InvalidArgumentException
         */
        public function getPosition($position)
        {
            if (isset($this->positions[$position])) {
                return $this->positions[$position];
            }

            throw new \InvalidArgumentException('Invalid Position "' . $position . '"');
        }

        /**
         * @param int $role
         *
         * @return string
         * @throws \InvalidArgumentException
         */
        public function getRole($role)
        {
            if (isset($this->roles[$role])) {
                return $this->roles[$role];
            }

            throw new \InvalidArgumentException('Invalid Role "' . $role . '"');
        }

        /**
         * @param string $position
         * @param string $role
         * @param string $champion
         *
         * @return string
         * @throws \OutOfBoundsException
         */
        public function map($position, $role, $champion)
        {
            switch ($position) {
                case 'TOP':
                    return 'TOP';
                case 'MID':
                case 'MIDDLE':
                    return 'MIDDLE';
                case 'BOT':
                case 'BOTTOM':
                    if ($role === 'DUO_SUPPORT') {
                        return 'SUPPORT';
                    }

                    if ($role === 'DUO_CARRY') {
                        return 'ADC';
                    }

                    $data = $this->leagueOfLegendsDataPoolReader->getChampionByName($champion);
                    if (in_array('Marksman', $data['tags'])) {
                        return 'ADC';
                    }

                    return 'SUPPORT';
                case 'JUNGLE':
                    return 'JUNGLE';
            }

            return 'UNKNOWN';
        }
    }
}
