<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\DataPool
{

    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\DataVersion;
    use Ganked\Library\ValueObjects\MetaTags;

    class DataPoolReader extends AbstractDataPool
    {
        /**
         * @var DataVersion
         */
        private $dataVersion;

        /**
         * @param string $path
         *
         * @return bool
         */
        public function hasStaticPage($path)
        {
            return $this->getBackend()->hHas((string) $this->getCurrentDataVersion(), 'sp_' . $path);
        }

        /**
         * @param string $path
         *
         * @return DomHelper
         */
        public function getStaticPageSnippet($path)
        {
            return new DomHelper($this->getBackend()->hGet((string) $this->getCurrentDataVersion(), 'sp_' . $path));
        }

        /**
         * @param string $path
         *
         * @return MetaTags
         */
        public function getMetaTagsForStaticPage($path)
        {
            return unserialize($this->getBackend()->hGet((string) $this->getCurrentDataVersion(), 'meta_' . $path));
        }

        /**
         * @param string $path
         *
         * @return string
         */
        public function getBodyClassForStaticPage($path)
        {
            return $this->getBackend()->hGet((string) $this->getCurrentDataVersion(), 'bodyClass_' . $path);
        }

        /**
         * @return array
         */
        public function getRecentSummonersList()
        {
            return $this->getBackend()->getList('lol:summoners:recent');
        }

        /**
         * @return array
         */
        public function getFreeChampionsList()
        {
            return $this->getBackend()->getList('lol:champions:free');
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
            if (!$this->getBackend()->hHas('lol:champions:list', $id)) {
                throw new \OutOfBoundsException('Champion for id "' . $id . '" not found');
            }

            return $this->getBackend()->hGet('lol:champions:list', $id);
        }

        /**
         * @return array
         */
        public function getAllChampions()
        {
            return $this->getBackend()->hGetAll('lol:champions:data');
        }

        /**
         * @return string
         */
        public function getCurrentLeagueOfLegendsPatch()
        {
            return $this->getBackend()->get('lol:patch');
        }

        /**
         * @param array $summoners
         *
         * @return array
         */
        public function getSummonersFromHash(array $summoners)
        {
            return $this->getBackend()->hMGet('lol:summoners', $summoners);
        }

        /**
         * @return bool
         */
        public function isInfoBarEnabled()
        {
            return $this->getBackend()->get('infoBarEnabled') === 'true';
        }

        /**
         * @return string
         */
        public function getInfoBarMessage()
        {
            return $this->getBackend()->get('infoBarMessage');
        }

        /**
         * @return array
         */
        public function getRssFeeds()
        {
            return $this->getBackend()->hGetAll('rss');
        }

        /**
         * @param string $game
         */
        public function getRssFeedsForGame($game)
        {
            return $this->getBackend()->hGet('rss', $game);
        }

        /**
         * @return DomHelper
         */
        public function getCounterStrikeAchievementsTemplate()
        {
            return new DomHelper($this->getBackend()->get('csgo:achievements:template'));
        }

        /**
         * @return DataVersion
         */
        public function getCurrentDataVersion()
        {
            if ($this->dataVersion === null) {
                $this->dataVersion = new DataVersion($this->getBackend()->get('currentDataVersion'));
            }

            return $this->dataVersion;
        }
    }
}
