<?php

/**
 * Copyright (c) 2015 Ganked
 * All rights reserved.
 */

namespace Ganked\Frontend\Mappers
{

    use Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader;

    class LeagueOfLegendsSummonerRunesMapper
    {
        /**
         * @var LeagueOfLegendsDataPoolReader
         */
        private $dataPoolReader;

        /**
         * @param LeagueOfLegendsDataPoolReader $dataPoolReader
         */
        public function __construct(LeagueOfLegendsDataPoolReader $dataPoolReader)
        {
            $this->dataPoolReader = $dataPoolReader;
        }

        /**
         * @param array $data
         *
         * @return array
         * @throws \InvalidArgumentException
         */
        public function map(array $data = [])
        {
            $runes = [];

            foreach($data['pages'] as $key => $page) {
                $rune = [
                    'id' => $page['id'],
                    'name' => $page['name'],
                    'isCurrent' => $page['current']
                ];

                $slots = [];

                if (!isset($page['slots'])) {
                    unset($data['pages'][$key]);
                    continue;
                }

                foreach($page['slots'] as $slot) {
                    $id = $slot['runeId'];

                    if (!$this->dataPoolReader->hasRune($id)) {
                        continue;
                    }

                    if (!isset($slots[$id])) {

                        $slots[$id] = [
                            'count' => 1,
                            'id' => $id,
                            'data' => $this->dataPoolReader->getRune($id)
                        ];

                        continue;
                    }

                    $slots[$id]['count']++;
                }

                $rune['slots'] = $slots;
                $runes[] = $rune;
            }

            return $runes;
        }
    }
}
