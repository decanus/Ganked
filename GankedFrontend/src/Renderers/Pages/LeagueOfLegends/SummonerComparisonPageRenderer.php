<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\Generators\ImageUriGenerator;
    use Ganked\Library\Generators\UriGenerator;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\KDA;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName;
    use Ganked\Skeleton\Transformations\SnippetTransformation;
    use Ganked\Skeleton\Transformations\TextTransformation;

    class SummonerComparisonPageRenderer extends AbstractPageRenderer
    {
        /**
         * @var NumberRowRenderer
         */
        private $numberRowRenderer;

        /**
         * @var UriGenerator
         */
        private $uriGenerator;

        /**
         * @var ImageUriGenerator
         */
        private $imageUriGenerator;

        /**
         * @var LeagueOfLegendsSearchBarRenderer
         */
        private $searchBarRenderer;

        /**
         * @param DomBackend                       $domBackend
         * @param DomHelper                        $template
         * @param SnippetTransformation            $snippetTransformation
         * @param TextTransformation               $textTransformation
         * @param GenericPageRenderer              $genericPageRenderer
         * @param NumberRowRenderer                $numberRowRenderer
         * @param UriGenerator                     $uriGenerator
         * @param ImageUriGenerator                $imageUriGenerator
         * @param LeagueOfLegendsSearchBarRenderer $searchBarRenderer
         */
        public function __construct(
            DomBackend $domBackend,
            DomHelper $template,
            SnippetTransformation $snippetTransformation,
            TextTransformation $textTransformation,
            GenericPageRenderer $genericPageRenderer,
            NumberRowRenderer $numberRowRenderer,
            UriGenerator $uriGenerator,
            ImageUriGenerator $imageUriGenerator,
            LeagueOfLegendsSearchBarRenderer $searchBarRenderer
        )
        {
            parent::__construct(
                $domBackend,
                $template,
                $snippetTransformation,
                $textTransformation,
                $genericPageRenderer
            );

            $this->numberRowRenderer = $numberRowRenderer;
            $this->uriGenerator = $uriGenerator;
            $this->imageUriGenerator = $imageUriGenerator;
            $this->searchBarRenderer = $searchBarRenderer;
        }

        protected function doRender()
        {
            $this->setTitle('Summoner Comparison');
            $template = $this->getTemplate();

            $this->getSnippetTransformation()->replaceElementWithId('header-search', $this->searchBarRenderer->render());

            $main = $template->getFirstElementByTagName('main');

            $stats = $this->getModel()->getSummonerData();

            $title = $template->createElement('h1', 'Summoner Comparison');
            $main->appendChild($title);

            if ($stats === null) {
                $this->renderError($main);
                return;
            }

            $this->renderCompareMessage($main, $stats);

            $statsDom = $this->getDomFromTemplate('templates://content/lol/comparison/stats.xhtml');
            $headerElement = $statsDom->getElementById('header');

            $this->renderRanked($statsDom, $stats);
            $this->renderUnranked($statsDom, $stats);

            foreach ($stats as $summoner) {
                $summonerImage = $statsDom->createElement('img');
                $summonerImage->setAttribute(
                    'src',
                    $this->imageUriGenerator->createSummonerProfileIconUri($summoner['profileIconId'])
                );
                $summonerImage->setAttribute('alt', $summoner['name']);
                $summonerImage->setAttribute('class', 'image');

                $summonerImageBox = $statsDom->createElement('div');
                $summonerImageBox->setAttribute('class', 'avatar-box -match');
                $summonerImageBox->appendChild($summonerImage);

                $summonerLink = $statsDom->createElement('a');
                $summonerLink->setAttribute(
                    'href',
                    $this->uriGenerator->createSummonerUri(new Region($summoner['region']), new SummonerName($summoner['name']))
                );
                $summonerLink->setAttribute('class', '_right');

                $summonerLink->appendChild($summonerImageBox);
                $summonerLink->appendChild($statsDom->createElement('p', $summoner['name']));

                $summonerDom = $statsDom->createElement('div');
                $summonerDom->setAttribute('class', 'value');
                $summonerDom->appendChild($summonerLink);

                $headerElement->appendChild($summonerDom);
            }

            $template->importAndAppendChild($template->getFirstElementByTagName('main'), $statsDom->documentElement);
        }

        /**
         * @param DomHelper $statsDom
         * @param array     $stats
         */
        private function renderRanked(DomHelper $statsDom, array $stats = [])
        {
            $tableElement = $statsDom->getElementById('table');

            $statsForTable = [];

            $rankedCount = 0;
            $summonerCount = count($stats);
            $summonerNames = [];
            foreach($stats as $summoner) {

                if (!isset($summoner['ranked'])) {
                    continue;
                }

                $summonerNames[] = $summoner['name'];

                $rankedCount++;

                $wins = 0;
                $losses = 0;
                $kills = 0;
                $assists = 0;
                $deaths = 0;
                foreach ($summoner['ranked'] as $ranked) {
                    $statistics = $ranked['stats'];

                    if (isset($statistics['totalSessionsWon'])) {
                        $wins += $statistics['totalSessionsWon'];
                    }

                    if (isset($statistics['totalSessionsLost'])) {
                        $losses += $statistics['totalSessionsLost'];
                    }

                    if (isset($statistics['totalChampionKills'])) {
                        $kills += $statistics['totalChampionKills'];
                    }

                    if (isset($statistics['totalAssists'])) {
                        $assists += $statistics['totalAssists'];
                    }

                    if (isset($statistics['totalDeathsPerSession'])) {
                        $deaths += $statistics['totalDeathsPerSession'];
                    }
                }

                $statsForTable['wins'][] = $wins;
                $statsForTable['losses'][] = $losses;
                $statsForTable['kills'][] = $kills;
                $statsForTable['deaths'][] = $deaths;
                $statsForTable['assists'][] = $assists;
                $statsForTable['kda'][] = (string) new KDA($kills, $deaths, $assists);
            }

            if ($rankedCount !== $summonerCount) {
                return;
            }

            $rankedTitle = $statsDom->createElement('h4', 'Ranked');
            $rankedTitle->setAttribute('class', 'title');
            $tableElement->appendChild($rankedTitle);

            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Wins', $statsForTable['wins']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Losses', $statsForTable['losses'], true));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('KDA', $statsForTable['kda']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Kills', $statsForTable['kills']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Deaths', $statsForTable['deaths'], true));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Assists', $statsForTable['assists']));
        }

        /**
         * @param DomHelper $statsDom
         * @param array     $stats
         */
        private function renderUnranked(DomHelper $statsDom, array $stats = [])
        {
            $tableElement = $statsDom->getElementById('table');

            $statsForTable = [];

            $unrankedTitle = $statsDom->createElement('h4', 'Unranked');
            $unrankedTitle->setAttribute('class', 'title');
            $tableElement->appendChild($unrankedTitle);

            foreach($stats as $summoner) {
                $kills = 0;
                $deaths = 0;
                $assists = 0;
                $damageDealtToChampions = 0;
                $creepScore = 0;
                $damageTaken = 0;
                $turretsKilled = 0;
                $goldEarned = 0;
                $killingSprees = 0;
                $totalHeal = 0;
                $ipEarned = 0;
                $wins = 0;

                foreach ($summoner['recent-games'] as $game) {
                    $stats = $game['stats'];
                    if (isset($stats['championsKilled'])) {
                        $kills += $stats['championsKilled'];
                    }

                    if (isset($stats['numDeaths'])) {
                        $deaths += $stats['numDeaths'];
                    }

                    if (isset($stats['assists'])) {
                        $assists += $stats['assists'];
                    }

                    if (isset($stats['totalDamageDealtToChampions'])) {
                        $damageDealtToChampions += $stats['totalDamageDealtToChampions'];
                    }

                    if (isset($stats['minionsKilled'])) {
                        $creepScore += $stats['minionsKilled'];
                    }

                    if (isset($stats['trueDamageTaken'])) {
                        $damageTaken += $stats['trueDamageTaken'];
                    }

                    if (isset($stats['turretsKilled'])) {
                        $turretsKilled += $stats['turretsKilled'];
                    }

                    if (isset($stats['goldEarned'])) {
                        $goldEarned += $stats['goldEarned'];
                    }

                    if (isset($stats['killingSprees'])) {
                        $killingSprees += $stats['killingSprees'];
                    }

                    if (isset($stats['totalHeal'])) {
                        $totalHeal += $stats['totalHeal'];
                    }

                    if (isset($game['ipEarned'])) {
                        $ipEarned += $game['ipEarned'];
                    }

                    if ($stats['win']) {
                        $wins += 1;
                    }
                }

                $statsForTable['kda'][] = (string) new KDA($kills, $deaths, $assists);
                $statsForTable['damageToChamps'][] = $damageDealtToChampions;
                $statsForTable['creepScore'][] = $creepScore;
                $statsForTable['damageTaken'][] = $damageTaken;
                $statsForTable['kills'][] = $kills;
                $statsForTable['deaths'][] = $deaths;
                $statsForTable['assists'][] = $assists;
                $statsForTable['turretsKilled'][] = $turretsKilled;
                $statsForTable['goldEarned'][] = $goldEarned;
                $statsForTable['killingSprees'][] = $killingSprees;
                $statsForTable['totalHeal'][] = $totalHeal;
                $statsForTable['ipEarned'][] = $ipEarned;
                $statsForTable['wins'][] = $wins;
            }

            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Wins', $statsForTable['wins']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('KDA', $statsForTable['kda']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Kills', $statsForTable['kills']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Deaths', $statsForTable['deaths'], true));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Assists', $statsForTable['assists']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Killing Sprees', $statsForTable['killingSprees']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Total Heal', $statsForTable['totalHeal']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('IP Earned', $statsForTable['ipEarned']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Gold Earned', $statsForTable['goldEarned']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Damage dealt to champions', $statsForTable['damageToChamps']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('CS', $statsForTable['creepScore']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Damage taken', $statsForTable['damageTaken'], true));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Turrets destroyed', $statsForTable['turretsKilled']));
        }

        /**
         * @param \DOMElement $main
         * @param array       $stats
         */
        private function renderCompareMessage(\DOMElement $main, array $stats = [])
        {
            $template = $this->getTemplate();

            $text = $template->createElement('small', 'You are currently comparing ');

            $keys = count($stats);
            $iteration = 0;
            foreach ($stats as $summoner) {
                if (!isset($summoner['name']) || !isset($summoner['region'])) {
                    continue;
                }

                $link = $template->createElement('a', $summoner['name']);
                $link->setAttribute('href', $this->uriGenerator->createSummonerUri(new Region($summoner['region']), new SummonerName($summoner['name'])));
                $text->appendChild($link);

                if ($iteration !== ($keys - 1) && $iteration !== ($keys - 2)) {
                    $text->appendChild($template->createTextNode(', '));
                }

                if ($iteration === ($keys - 2)) {
                    $text->appendChild($template->createTextNode(' and '));
                }

                $iteration++;
            }

            $main->appendChild($text);
        }

        /**
         * @param \DOMElement $main
         */
        private function renderError(\DOMElement $main)
        {
            $template = $this->getTemplate();

            $text = $template->createElement('small', 'You do not seem to have added any summoners to compare, search for summoners and add them.');
            $text->setAttribute('class', '_dim -center');
            $main->appendChild($text);
        }
    }
}
