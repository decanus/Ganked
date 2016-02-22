<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers 
{

    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\KDA;
    use Ganked\Library\ValueObjects\StatisticNumber;

    class SummonerPageRenderer extends AbstractSummonerPageRenderer
    {
        /**
         * @return DomHelper
         */
        protected function renderContent()
        {
            $matchesDom = new DomHelper('<div />');
            $model = $this->getModel();
            $matches = $model->getRecentMatches();
            $summoner = $model->getSummoner();
            $uriBuilder = $this->getUriBuilder();

            if ($matches === null) {
                $matchesDom->firstChild->appendChild(
                    $matchesDom->createElement('span', 'No recent matches were found.')
                );

                return $matchesDom;
            }

            $this->renderAverages($matchesDom);

            foreach($matches['games'] as $match) {
                $matchDom = $this->getDomFromTemplate('templates://content/lol/summoner/match.xhtml');
                $stats = $match['stats'];

                $date = (new \DateTime('@' . round($match['createDate'] / 1000)));

                $dateDom = $matchDom->getElementById('date');
                $dateDom->setAttribute('datetime', $date->format(\DateTime::W3C));
                $dateDom->nodeValue = 'on ' . $date->format('M d');

                $duration = $match['stats']['timePlayed'];
                $durationFormat = 'H:i:s';

                if ($duration < 3600) {
                    $durationFormat = 'i:s';
                }

                $matchDom->getElementById('duration')->nodeValue = gmdate($durationFormat, $duration);
                $matchDom->getElementById('gameMode')->nodeValue = $match['gameMode'];
                $matchDom
                    ->getElementById('matchLink')
                    ->setAttribute('href', $uriBuilder->createMatchPageUri($summoner->getRegion(), $match['gameId']));

                $champion = $this->getLeagueOfLegendsDataPoolReader()->getChampionByName($match['championId']);

                $championImage = $matchDom->getElementById('championImage');
                $championImage->setAttribute('alt', $match['championId']);

                $championImage->setAttribute(
                    'src',
                    '//cdn.ganked.net/images/lol/champion/icon/' . $match['championId'] . '.png'
                );

                $matchDom->getElementById('championName')->nodeValue = $champion['name'];
                $matchDom->getElementById('championDescription')->nodeValue = ucfirst($champion['title']);

                $gameStatus = $matchDom->getElementById('gameStatus');
                $gameStatus->nodeValue = $match['stats']['win'] ? 'VICTORY' : 'DEFEAT';
                $gameStatus->setAttribute('class', '_caps _' . ($match['stats']['win'] ? 'green' : 'red'));

                $matchDom->getElementById('gameLevel')->nodeValue = 'Level ' . $match['stats']['level'];

                $color = 'blue';
                if ($match['teamId'] === 200) {
                    $color = 'purple';
                }

                $championLink = $matchDom->getElementById('championLink');
                $championLink->setAttribute('href', $uriBuilder->createChampionPageUri($champion['key']));
                $championLink->setAttribute('class', $championLink->getAttribute('class') . ' -' . $color);

                $itemKeys = ['item0', 'item1', 'item2', 'item3', 'item4', 'item5', 'item6'];

                foreach($itemKeys as $key) {
                    if (!isset($stats[$key])) {
                        $matchDom->getElementById($key)->removeAttribute('data-info-box');
                        continue;
                    }

                    $itemData = $stats[$key];
                    $name = $itemData['name'];
                    $gold = new StatisticNumber($itemData['gold']['total']);

                    $matchDom->getElementById($key . 'name')->nodeValue = $itemData['name'];

                    if (isset($itemData['plaintext'])) {
                        $matchDom->getElementById($key . 'description')->nodeValue = $itemData['plaintext'];
                    }

                    $matchDom->getElementById($key . 'gold')->nodeValue = $gold->getRounded() . ' Gold';

                    $itemImage = new DomHelper(
                        '<img src="//cdn.ganked.net/images/lol/item/' . $itemData['image']['full'] . '" alt="' . $name . '" class="image" />'
                    );

                    $matchDom->importAndAppendChild(
                        $matchDom->getElementById($key),
                        $itemImage->firstChild
                    );
                }

                $minions = 0;
                if (isset($stats['minionsKilled'])) {
                    $minions = $stats['minionsKilled'];
                }

                if (isset($stats['neutralMinionsKilledYourJungle'])) {
                    $minions += $stats['neutralMinionsKilledYourJungle'];
                }

                if (isset($stats['neutralMinionsKilledEnemyJungle'])) {
                    $minions += $stats['neutralMinionsKilledEnemyJungle'];
                }

                $matchDom->getElementById('minions')->nodeValue = $minions;

                $gold = 0;
                if (isset($stats['goldEarned'])) {
                    $gold = $stats['goldEarned'];
                }

                $matchDom->getElementById('gold')->nodeValue = (new StatisticNumber($gold))->getRounded();

                $totalDamageDealtToChampions = 0;
                if (isset($stats['totalDamageDealtToChampions'])) {
                    $totalDamageDealtToChampions = $stats['totalDamageDealtToChampions'];
                }

                $matchDom->getElementById('damageDealtToChampions')->nodeValue = (new StatisticNumber($totalDamageDealtToChampions))->getRounded();

                $damageTaken = 0;
                if (isset($stats['totalDamageTaken'])) {
                    $damageTaken = $stats['totalDamageTaken'];
                }

                $matchDom->getElementById('damageTaken')->nodeValue = (new StatisticNumber($damageTaken))->getRounded();


                $wardsBought = 0;
                if (isset($stats['sightWardsBought'])) {
                    $wardsBought += $stats['sightWardsBought'];
                }

                if (isset($stats['visionWardsBought'])) {
                    $wardsBought += $stats['visionWardsBought'];
                }

                $wardsPlaced = 0;
                if (isset($stats['wardPlaced'])) {
                    $wardsPlaced = $stats['wardPlaced'];
                }

                $matchDom->getElementById('wardsBought')->nodeValue = $wardsBought;
                $matchDom->getElementById('wardsPlaced')->nodeValue = $wardsPlaced;

                $kills = 0;
                if (isset($stats['championsKilled'])) {
                    $kills = $stats['championsKilled'];
                }

                $deaths = 0;
                if (isset($stats['numDeaths'])) {
                    $deaths = $stats['numDeaths'];
                }

                $assists = 0;
                if (isset($stats['assists'])) {
                    $assists = $stats['assists'];
                }

                if (isset($match['role']) && $match['role'] !== 'UNKNOWN') {
                    $matchDom->getElementById('role')->nodeValue = $match['role'];
                } else {
                    $element = $matchDom->getElementById('roleWrapper');
                    $element->parentNode->removeChild($element);
                }

                $matchDom->getElementById('gameKda')->nodeValue = $kills . ' / ' . $deaths . ' / ' . $assists;

                $kda = new KDA($kills, $deaths, $assists);
                $matchDom->getElementById('gameKdaRatio')->nodeValue = (string) $kda . ' KDA';
                $matchesDom->importAndAppendChild($matchesDom->firstChild, $matchDom->firstChild);
            }

            return $matchesDom;
        }

        /**
         * @param DomHelper $dom
         */
        private function renderAverages(DomHelper $dom)
        {
            $matches = $this->getModel()->getRecentMatches();

            $box = $dom->createElement('article');
            $box->setAttribute('class', 'generic-box -normal-padding');

            $grid = $dom->createElement('div');
            $grid->setAttribute('class', 'grid-wrapper -gap -space-between');

            $winLossStatsItem = $dom->createElement('div');
            $winLossStatsItem->setAttribute('class', 'item -center');

            $winLossGrid = $dom->createElement('div');
            $winLossGrid->setAttribute('class', 'grid-wrapper -gap');
            $winLossStatsItem->appendChild($winLossGrid);

            $numWins =  (isset($matches['wins']) ? $matches['wins'] : 0);
            $games = (isset($matches['games']) ? count($matches['games']) : 0);

            $winsItem = $dom->createElement('small', 'Wins ');
            $winsItem->setAttribute('class', 'item');
            $wins = $dom->createElement('span', $numWins);
            $wins->setAttribute('class', '_green');
            $winsItem->appendChild($wins);
            $winLossGrid->appendChild($winsItem);

            $lossesItem = $dom->createElement('small', 'Losses ');
            $lossesItem->setAttribute('class', 'item');
            $losses = $dom->createElement('span', ($games - $numWins));
            $losses->setAttribute('class', '_red');
            $lossesItem->appendChild($losses);
            $winLossGrid->appendChild($lossesItem);
            $grid->appendChild($winLossStatsItem);

            $kda = $dom->createElement(
                'small',
                'Average ' . new KDA($matches['kills'], $matches['deaths'], $matches['assists']) . ' KDA'
            );
            $kda->setAttribute('class', 'item -center');
            $grid->appendChild($kda);

            $totalStatistics = $dom->createElement(
                'small',
                $matches['kills'] . ' / ' . $matches['deaths'] . ' / ' . $matches['assists']
            );
            $totalStatistics->setAttribute('class', 'item -center');
            $grid->appendChild($totalStatistics);

            $box->appendChild($grid);

            $dom->firstChild->appendChild($box);
        }

        /**
         * @return string
         */
        protected function getTitle()
        {
            return 'Recent Matches';
        }

        /**
         * @return int
         */
        protected function getActiveNavItem()
        {
            return 1;
        }
    }
}
