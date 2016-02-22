<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\DataPool
{
    use Ganked\Library\Helpers\DomHelper;

    class DataPoolWriter extends AbstractDataPool
    {
        /**
         * @param string $region
         * @param array  $summoner
         */
        public function addSummonerToRecentList($region, $summoner)
        {
            $this->setLeagueOfLegendsSummoner($region, $summoner);
            $recentSummoners = $this->getBackend()->lRange('lol:summoners:recent', 0, 3);

            $summoner['region'] = $region;

            foreach ($recentSummoners as $recentSummoner) {

                $recentSummoner = json_decode($recentSummoner, true);

                if ($recentSummoner['id'] === $summoner['id'] && $recentSummoner['region'] === $summoner['region']) {
                    return;
                }

            }

            $this->getBackend()->lPush('lol:summoners:recent', json_encode($summoner));
            $this->getBackend()->lTrim('lol:summoners:recent', 0, 3);
        }

        /**
         * @param array $champions
         */
        public function setFreeChampions(array $champions)
        {
            $this->getBackend()->delete('lol:champions:free');

            foreach ($champions as $champion) {
                $this->getBackend()->lPush('lol:champions:free', $champion);
            }
        }

        /**
         * @param string $key
         * @param string $champion
         */
        public function setLeagueOfLegendsChampionData($key, $champion)
        {
            $this->getBackend()->hSet('lol:champions:data', $key, $champion);
        }

        /**
         * @param string $id
         * @param string $name
         */
        public function appendLeagueOfLegendsChampionToList($id, $name)
        {
            $this->getBackend()->hSet('lol:champions:list', $id, $name);
        }

        /**
         * @param string $patch
         */
        public function setCurrentLeagueOfLegendsPatch($patch)
        {
            $this->getBackend()->set('lol:patch', $patch);
        }

        /**
         * @param DomHelper $template
         */
        public function setLeagueOfLegendsMasteriesTemplate(DomHelper $template)
        {
            $this->getBackend()->set('lol:masteries:template', $template->saveXML());
        }

        /**
         * @param string $region
         * @param array  $summoner
         */
        public function setLeagueOfLegendsSummoner($region, array $summoner)
        {
            $summoner['region'] = $region;
            $this->getBackend()->hSet('lol:summoners', $summoner['id'] . ':' . $region, json_encode($summoner));
        }

        /**
         * @param string    $game
         * @param DomHelper $feed
         */
        public function setRssFeedForGame($game, DomHelper $feed)
        {
            $this->getBackend()->hSet('rss', $game, $feed->saveXML());
        }

        /**
         * @param DomHelper $template
         */
        public function setCounterStrikeAchievementsTemplate(DomHelper $template)
        {
            $this->getBackend()->set('csgo:achievements:template', $template->saveXML());
        }
    }
}
