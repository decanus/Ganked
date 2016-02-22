<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers {

    use Ganked\Frontend\Models\SummonerCurrentGamePageModel;
    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\Generators\ImageUriGenerator;
    use Ganked\Library\Generators\UriGenerator;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName;
    use Ganked\Library\ValueObjects\Map;
    use Ganked\Skeleton\Transformations\SnippetTransformation;
    use Ganked\Skeleton\Transformations\TextTransformation;

    class SummonerCurrentGamePageRenderer extends AbstractPageRenderer
    {
        /**
         * @var LeagueOfLegendsChampionTooltipRenderer
         */
        private $leagueOfLegendsChampionTooltipRenderer;

        /**
         * @var UriGenerator
         */
        private $uriBuilder;

        /**
         * @var LeagueOfLegendsBannedChampionsRenderer
         */
        private $leagueOfLegendsBannedChampionsRenderer;

        /**
         * @var ImageUriGenerator
         */
        private $imageUriGenerator;

        /**
         * @var MasteriesSnippetRenderer
         */
        private $masteriesSnippetRenderer;

        /**
         * @var LeagueOfLegendsRunesSnippetRenderer
         */
        private $leagueOfLegendsRunesSnippetRenderer;

        /**
         * @param DomBackend $domBackend
         * @param DomHelper $template
         * @param SnippetTransformation $snippetTransformation
         * @param TextTransformation $textTransformation
         * @param GenericPageRenderer $genericPageRenderer
         * @param LeagueOfLegendsChampionTooltipRenderer $leagueOfLegendsChampionTooltipRenderer
         * @param UriGenerator $uriBuilder
         * @param ImageUriGenerator $imageUriGenerator
         * @param LeagueOfLegendsBannedChampionsRenderer $leagueOfLegendsBannedChampionsRenderer
         * @param MasteriesSnippetRenderer $masteriesSnippetRenderer
         * @param LeagueOfLegendsRunesSnippetRenderer $leagueOfLegendsRunesSnippetRenderer
         */
        public function __construct(
            DomBackend $domBackend,
            DomHelper $template,
            SnippetTransformation $snippetTransformation,
            TextTransformation $textTransformation,
            GenericPageRenderer $genericPageRenderer,
            LeagueOfLegendsChampionTooltipRenderer $leagueOfLegendsChampionTooltipRenderer,
            UriGenerator $uriBuilder,
            ImageUriGenerator $imageUriGenerator,
            LeagueOfLegendsBannedChampionsRenderer $leagueOfLegendsBannedChampionsRenderer,
            MasteriesSnippetRenderer $masteriesSnippetRenderer,
            LeagueOfLegendsRunesSnippetRenderer $leagueOfLegendsRunesSnippetRenderer
        )
        {
            parent::__construct(
                $domBackend,
                $template,
                $snippetTransformation,
                $textTransformation,
                $genericPageRenderer
            );

            $this->leagueOfLegendsChampionTooltipRenderer = $leagueOfLegendsChampionTooltipRenderer;
            $this->uriBuilder = $uriBuilder;
            $this->imageUriGenerator = $imageUriGenerator;
            $this->leagueOfLegendsBannedChampionsRenderer = $leagueOfLegendsBannedChampionsRenderer;
            $this->masteriesSnippetRenderer = $masteriesSnippetRenderer;
            $this->leagueOfLegendsRunesSnippetRenderer = $leagueOfLegendsRunesSnippetRenderer;
        }

        protected function doRender()
        {
            /**
             * @var $model SummonerCurrentGamePageModel
             */
            $model = $this->getModel();
            $template = $this->getTemplate();
            $this->setTitle($model->getSummoner()->getName() . ' - Current Game');

            if ($model->getCurrentGame() === []) {
                return $this->renderNoMatch();
            }

            $main = $template->getFirstElementByTagName('main');

            $template->getElementById('body')->insertBefore($this->renderHeader(), $main);
            $main->appendChild($this->renderTimeline());
            $main->appendChild($this->renderPlayers());
        }

        private function renderNoMatch()
        {
            $summoner = $this->getModel()->getSummoner();
            $summonerName = $summoner->getName();

            $dom = $this->getDomFromTemplate('templates://content/lol/summoner/current/no-match.xhtml');
            $dom->getElementById('summonerName')->nodeValue = $summonerName;

            $link = $dom->getElementById('link');
            $link->nodeValue = $summonerName . '\'s Page';
            $link->setAttribute('href', $this->uriBuilder->createSummonerUri($summoner->getRegion(), new SummonerName($summonerName)));

            $this->getSnippetTransformation()->appendToMain($dom);
        }

        /**
         * @return \DOMDocumentFragment
         */
        private function renderHeader()
        {
            $game = $this->getModel()->getCurrentGame();
            $summoner = $this->getModel()->getSummoner();

            $template = $this->getTemplate();
            $header = $template->createDocumentFragment();

            try {
                $headerClass = 'landing-header -padding -' . (string) new Map($game['mapId']);
            } catch (\InvalidArgumentException $e) {
                $headerClass = 'landing-header -lol -padding';
            }

            $wrap = $header->appendChild($template->createElement('header'));
            $wrap->setAttribute('class', 'page-wrap');

            $landingHeader = $wrap->appendChild($template->createElement('div'));
            $landingHeader->setAttribute('class', $headerClass);

            $landingWrap = $landingHeader->appendChild($template->createElement('div'));
            $landingWrap->setAttribute('class', 'landing-wrap _center');

            $startTime = new \DateTime('@' . round($game['gameStartTime'] / 1000));
            $now = new \DateTime;
            $timePlayed = $now->diff($startTime)->format('%I:%S');

            $title = $landingWrap->appendChild($template->createElement('h1', $timePlayed));
            $title->setAttribute('class', 'landing-title');

            $gameInfo = $landingWrap->appendChild($template->createElement('p'));

            $summonerLink = $gameInfo->appendChild($template->createElement('a', $summoner->getName()));
            $summonerLink->setAttribute('href', $this->uriBuilder->createSummonerUri(
                $summoner->getRegion(),
                new SummonerName($summoner->getName())
            ));

            $gameInfo->appendChild($template->createTextNode(' playing '));

            $gameMode = $gameInfo->appendChild($template->createElement('span', $game['gameMode']));
            $gameMode->setAttribute('class', '_blue');

            return $header;
        }

        /**
         * @return \DOMDocumentFragment
         */
        private function renderTimeline()
        {
            /**
             * @var $model SummonerCurrentGamePageModel
             */
            $model = $this->getModel();
            $game = $model->getCurrentGame();
            $summoner = $model->getSummoner();
            $template = $this->getTemplate();
            $content = $template->createDocumentFragment();

            $grid = $content->appendChild($template->createElement('div'));
            $grid->setAttribute('class', 'grid-wrapper -gap');

            $blueTeam = $grid->appendChild($template->createElement('div'));
            $blueTeam->setAttribute('class', 'item -half -flex -stretch');

            $blueTeamHeader = $blueTeam->appendChild($template->createElement('header'));
            $blueTeamHeader->setAttribute('class', 'grid-wrapper -gap -space-between -full');

            $blueTeamBanned = $this->leagueOfLegendsBannedChampionsRenderer->render($game['bannedChampions'], 100);
            $template->importAndAppendChild($blueTeamHeader, $blueTeamBanned->firstChild);

            $blueTeamCircleWrap = $blueTeamHeader->appendChild($template->createElement('div'));
            $blueTeamCircleWrap->setAttribute('class', 'item -center');

            $blueTeamCircle = $blueTeamCircleWrap->appendChild($template->createElement('div'));
            $blueTeamCircle->setAttribute('class', 'color-circle -blue');

            $purpleTeam = $grid->appendChild($template->createElement('div'));
            $purpleTeam->setAttribute('class', 'item -half -flex -stretch');

            $purpleTeamHeader = $purpleTeam->appendChild($template->createElement('header'));
            $purpleTeamHeader->setAttribute('class', 'grid-wrapper -gap -space-between -reverse -full');

            $purpleTeamBanned = $this->leagueOfLegendsBannedChampionsRenderer->render($game['bannedChampions'], 200);
            $template->importAndAppendChild($purpleTeamHeader, $purpleTeamBanned->firstChild);

            $purpleTeamCircleWrap = $purpleTeamHeader->appendChild($template->createElement('div'));
            $purpleTeamCircleWrap->setAttribute('class', 'item -center');

            $purpleTeamCircle = $purpleTeamCircleWrap->appendChild($template->createElement('div'));
            $purpleTeamCircle->setAttribute('class', 'color-circle -purple');

            $timelineSection = $content->appendChild($template->createElement('section'));
            $timelineSection->setAttribute('class', 'page-section');

            $timeline = $timelineSection->appendChild($template->createElement('div'));
            $timeline->setAttribute('class', 'match-timeline');

            $blueTimeline = $timeline->appendChild($template->createElement('div'));
            $blueTimeline->setAttribute('class', 'team');

            $purpleTimeline = $timeline->appendChild($template->createElement('div'));
            $purpleTimeline->setAttribute('class', 'team');

            foreach ($game['participants'] as $participant) {
                $teamElement = $blueTimeline;
                $playerElementClass = 'match-timeline-player';

                if ($participant['teamId'] === 200) {
                    $teamElement = $purpleTimeline;
                    $playerElementClass .= ' -mirror';
                }

                $playerElement = $teamElement->appendChild($template->createElement('div'));
                $playerElement->setAttribute('class', $playerElementClass);

                $championData = $participant['champion'];
                $champion = $this->leagueOfLegendsChampionTooltipRenderer->render($championData);
                $champion->firstChild->setAttribute('class', 'champion');
                $champion->query('/div/a')->item(0)->setAttribute('class', 'avatar-box -match-overview');
                $template->importAndAppendChild($playerElement, $champion->firstChild);

                $name = $playerElement->appendChild($template->createElement('div'));
                $name->setAttribute('class', 'name');

                if(isset($participant['summonerName'])) {
                    $summonerUri = $this->uriBuilder->createSummonerUri($summoner->getRegion(), new SummonerName($participant['summonerName']));

                    $playerName = $name->appendChild($template->createElement('a', $participant['summonerName']));
                    $playerName->setAttribute('href', $summonerUri);
                } else {
                    $playerName = $name->appendChild($template->createElement('p', $championData['name']));
                    $playerName->setAttribute('class', '_noMargin');
                }

                $gamesItem = $playerElement->appendChild($template->createElement('div'));
                $gamesItem->setAttribute('class', 'games');

                $totalGames = 0;
                if(isset($participant['matchlist']['totalGames'])) {
                    $totalGames = $participant['matchlist']['totalGames'];
                }

                $gamesItem->appendChild($template->createElement('small', $totalGames . ' Games'));

                $laneItem = $playerElement->appendChild($template->createElement('div'));
                $laneItem->setAttribute('class', 'lane _center');

                if (isset($participant['stats']['topLane'])) {
                    $lane = $laneItem->appendChild($template->createElement('span', $participant['stats']['topLane']));
                    $lane->setAttribute('class', 'pill-span');
                }

                $spellsItem = $playerElement->appendChild($template->createElement('div'));
                $spellsItem->setAttribute('class', 'spells');

                $spells = $spellsItem->appendChild($template->createElement('div'));
                $spells->setAttribute('class', 'grid-wrapper -gap');

                $spell1Item = $spells->appendChild($template->createElement('div'));
                $spell1Item->setAttribute('class', 'item -center');

                $spell1 = $spell1Item->appendChild($template->createElement('div'));
                $spell1->setAttribute('class', 'summoner-item');

                $spell2Item = $spells->appendChild($template->createElement('div'));
                $spell2Item->setAttribute('class', 'item -center');

                $spell2 = $spell2Item->appendChild($template->createElement('div'));
                $spell2->setAttribute('class', 'summoner-item');

                if (isset($participant['spell1'])) {
                    $spell1Image = $spell1->appendChild($template->createElement('img'));
                    $spell1Image->setAttribute('src', $this->imageUriGenerator->createLeagueOfLegendsSpellIconUri($participant['spell1']['image']['full']));
                }

                if (isset($participant['spell2'])) {
                    $spell2Image = $spell2->appendChild($template->createElement('img'));
                    $spell2Image->setAttribute('src', $this->imageUriGenerator->createLeagueOfLegendsSpellIconUri($participant['spell2']['image']['full']));
                }
            }

            return $content;
        }

        /**
         * @return \DOMDocumentFragment
         */
        private function renderPlayers()
        {
            /**
             * @var $model SummonerCurrentGamePageModel
             */
            $model = $this->getModel();
            $game = $model->getCurrentGame();
            $template = $this->getTemplate();
            $content = $template->createDocumentFragment();
            $section = $content->appendChild($template->createElement('section'));
            $section->setAttribute('class', 'page-section');

            $tabs = $section->appendChild($template->createElement('div'));
            $tabs->setAttribute('class', 'match-player-tabs');

            $icons = $tabs->appendChild($template->createElement('nav'));
            $icons->setAttribute('class', 'players');

            $title = $icons->appendChild($template->createElement('h2', 'Players'));
            $title->setAttribute('class', 'title');

            $players = $tabs->appendChild($template->createElement('div'));
            $players->setAttribute('class', 'content');

            foreach($game['participants'] as $i => $participant) {
                $tabId = 'player-' . ($i + 1);

                $tabLinkWrap = $icons->appendChild($template->createElement('div'));
                $tabLinkWrap->setAttribute('class', 'player');

                $tabLinkClass = 'avatar-box -match-overview';

                if ($i === 0) {
                    $tabLinkClass .= ' -active';
                }

                $tabLink = $tabLinkWrap->appendChild($template->createElement('a'));
                $tabLink->setAttribute('href', '#' . $tabId);
                $tabLink->setAttribute('is', 'tab-link');
                $tabLink->setAttribute('class', $tabLinkClass);

                $championImage = $tabLink->appendChild($template->createElement('img'));
                $championImage->setAttribute('src', $this->imageUriGenerator->createChampionIconUri($participant['champion']['key']));
                $championImage->setAttribute('alt', $participant['summonerName']);
                $championImage->setAttribute('class', 'image');

                $tabContent = $players->appendChild($template->createElement('gnkd-tab'));
                $tabContent->setAttribute('id', $tabId);
                $tabContent->setAttribute('data-render-keepid', '');
                $tabContent->setAttribute('group', 'players');

                if ($i > 0) {
                    $tabContent->setAttribute('hidden', 'hidden');
                }

                $summonerName = $tabContent->appendChild($template->createElement('h3', $participant['summonerName']));
                $summonerName->setAttribute('class', '_noMargin');

                if (isset($participant['masteries'])) {
                    $masteriesSection = $tabContent->appendChild($template->createElement('section'));
                    $masteriesSection->appendChild($template->createElement('h4', 'Masteries'));

                    $summonerMasteries = $this->masteriesSnippetRenderer->render($participant['masteries']);
                    $template->importAndAppendChild($masteriesSection, $summonerMasteries->firstChild);
                }

                if (isset($participant['runes'])) {
                    $runesSection = $tabContent->appendChild($template->createElement('section'));
                    $runesSection->appendChild($template->createElement('h4', 'Runes'));

                    $runes = $this->leagueOfLegendsRunesSnippetRenderer->render($participant['runes']);
                    $template->importAndAppendChild($runesSection, $runes->firstChild);
                }
            }

            return $content;
        }
    }
}
