<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Frontend\Models\MatchPageModel;
    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\Generators\UriGenerator;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\KDA;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName;
    use Ganked\Library\ValueObjects\Map;
    use Ganked\Library\ValueObjects\StatisticNumber;
    use Ganked\Skeleton\Transformations\SnippetTransformation;
    use Ganked\Skeleton\Transformations\TextTransformation;

    class MatchPageRenderer extends AbstractPageRenderer
    {
        /**
         * @var LeagueOfLegendsSearchBarRenderer
         */
        private $leagueOfLegendsSearchBarRenderer;

        /**
         * @var LeagueOfLegendsChampionTooltipRenderer
         */
        private $leagueOfLegendsChampionTooltipRenderer;

        /**
         * @var UriGenerator
         */
        private $uriBuilder;

        /**
         * @var string
         */
        private $matchType;

        /**
         * @var BarGraphRenderer
         */
        private $barGraphRenderer;

        /**
         * @var BoolRowRenderer
         */
        private $boolRowRenderer;

        /**
         * @var NumberRowRenderer
         */
        private $numberRowRenderer;

        /**
         * @var array
         */
        private $items = ['item0', 'item1', 'item2', 'item3', 'item4', 'item5', 'item6'];

        /**
         * @var bool
         */
        private $isDevelopmentMode;

        /**
         * @param DomBackend                             $domBackend
         * @param DomHelper                              $template
         * @param SnippetTransformation                  $snippetTransformation
         * @param TextTransformation                     $textTransformation
         * @param GenericPageRenderer                    $genericPageRenderer
         * @param LeagueOfLegendsSearchBarRenderer       $leagueOfLegendsSearchBarRenderer
         * @param LeagueOfLegendsChampionTooltipRenderer $leagueOfLegendsChampionTooltipRenderer
         * @param UriGenerator                           $uriBuilder
         * @param BarGraphRenderer                       $barGraphRenderer
         * @param BoolRowRenderer                        $boolRowRenderer
         * @param NumberRowRenderer                      $numberRowRenderer
         * @param bool                                   $isDevelopmentMode
         */
        public function __construct(
            DomBackend $domBackend,
            DomHelper $template,
            SnippetTransformation $snippetTransformation,
            TextTransformation $textTransformation,
            GenericPageRenderer $genericPageRenderer,
            LeagueOfLegendsSearchBarRenderer $leagueOfLegendsSearchBarRenderer,
            LeagueOfLegendsChampionTooltipRenderer $leagueOfLegendsChampionTooltipRenderer,
            UriGenerator $uriBuilder,
            BarGraphRenderer $barGraphRenderer,
            BoolRowRenderer $boolRowRenderer,
            NumberRowRenderer $numberRowRenderer,
            $isDevelopmentMode = false
        )
        {
            parent::__construct(
                $domBackend,
                $template,
                $snippetTransformation,
                $textTransformation,
                $genericPageRenderer
            );

            $this->leagueOfLegendsSearchBarRenderer = $leagueOfLegendsSearchBarRenderer;
            $this->leagueOfLegendsChampionTooltipRenderer = $leagueOfLegendsChampionTooltipRenderer;
            $this->uriBuilder = $uriBuilder;
            $this->barGraphRenderer = $barGraphRenderer;
            $this->boolRowRenderer = $boolRowRenderer;
            $this->numberRowRenderer = $numberRowRenderer;
            $this->isDevelopmentMode = $isDevelopmentMode;
        }

        protected function doRender()
        {
            /**
             * @var $model MatchPageModel
             */
            $model = $this->getModel();
            $this->matchType = $model->getMatchData()['matchMode'];
            $this->setTitle($this->matchType);

            $snippetTransformation = $this->getSnippetTransformation();

            $this->getTemplate()->getElementById('main')->setAttribute('class', '');
            $snippetTransformation->appendToMain($this->renderHeader());
            $snippetTransformation->appendToMain($this->renderContent());
            $snippetTransformation->appendToMain($this->renderStats());
            $this->renderPlayers();
            $snippetTransformation->replaceElementWithId(
                'header-search',
                $this->leagueOfLegendsSearchBarRenderer->render($model->getRequestUri())
            );
        }

        /**
         * @return DomHelper
         */
        private function renderHeader()
        {
            $matchData = $this->getModel()->getMatchData();

            try {
                $headerClass = 'landing-header -padding -' . (string) new Map($matchData['mapId']);
            } catch (\InvalidArgumentException $e) {
                $headerClass = 'landing-header -lol -padding';
            }

            $header = $this->getDomFromTemplate('templates://content/lol/match/header.xhtml');
            $header->getElementById('gameMode')->nodeValue = $matchData['matchMode'];
            $header->getElementById('header')->setAttribute('class', $headerClass);

            $startTime = new \DateTime('@' . round($matchData['matchCreation'] / 1000));
            $header->getElementById('matchDate')->setAttribute('datetime', $startTime->format(\DateTime::W3C));
            $header->getElementById('matchDate')->nodeValue = 'on ' . $startTime->format('M d');

            $header->getElementById('matchDuration')->nodeValue = gmdate('i:s', $matchData['matchDuration']);

            return $header;
        }

        /**
         * @return DomHelper
         */
        private function renderContent()
        {
            $content = $this->getDomFromTemplate('templates://content/lol/match/content.xhtml');
            $data = $this->getModel()->getMatchData();
            $teams = $data['teams'];

            foreach($teams as $team) {

                $color = 'blue';
                if ($team['teamId'] === 200) {
                    $color = 'purple';
                }

                $this->renderBannedChampions($content, $team, $color);
                $this->renderTimeline($content, $team, $color);

                if (isset($team['winner']) && $team['winner']) {
                    $gameStatus = $content->getElementById($color . '-gameStatus');
                    $gameStatus->nodeValue = 'Victory';
                    $gameStatus->setAttribute('class', '_green');
                }

                $content->getElementById($color . '-baronKills')->nodeValue = $team['baronKills'];
                $content->getElementById($color . '-dragonKills')->nodeValue = $team['dragonKills'];
                $content->getElementById($color . '-towerKills')->nodeValue = $team['towerKills'];
                $content->getElementById($color . '-totalKills')->nodeValue = $team['totalKills'];
                $content->getElementById($color . '-gold')->nodeValue = (new StatisticNumber($team['totalGold']))->getRounded();
            }

            return $content;
        }

        /**
         * @param DomHelper $content
         * @param array     $team
         * @param string    $color
         */
        private function renderBannedChampions(DomHelper $content, array $team, $color)
        {
            if (!isset($team['bans'])) {
                $node = $content->getElementById($color . '-banned-wrapper');
                $node->parentNode->removeChild($node);
                return;
            }

            foreach ($team['bans'] as $banned) {
                $bannedDom = $this->leagueOfLegendsChampionTooltipRenderer->render($banned);
                $bannedDom->getFirstElementByTagName('a')->setAttribute('class', 'avatar-box -match-overview');
                $content->importAndAppendChild($content->getElementById($color . '-banned'), $bannedDom->documentElement);
            }
        }

        /**
         * @param DomHelper $content
         * @param array     $team
         * @param string    $color
         */
        private function renderTimeline(DomHelper $content, array $team, $color)
        {
            $matchData = $this->getModel()->getMatchData();
            $players = [];

            $params = ['id' => $matchData['matchId'], 'region' => $matchData['region']];
            $fetchHost = '//fetch.ganked.net';
            if ($this->isDevelopmentMode) {
                $fetchHost = '//dev.fetch.ganked.net';
            }

            if ($matchData['hasTimeline']) {
                $content->getElementById('timeline')->setAttribute('href', $fetchHost . '/fetch/match?' . http_build_query($params));
            } else {
                $controls = $content->getElementById('timeline-controls');
                $controls->parentNode->removeChild($controls);
            }

            foreach($team['participants'] as $player) {

                $champion = $player['champion'];
                $playerName = $champion['name'];
                $playerDom = $this->getDomFromTemplate('templates://content/lol/match/timeline.xhtml');
                $stats = $player['stats'];

                $lane = '';
                $role = '';

                if (isset($player['mvp']) && $player['mvp']) {
                    $small = $playerDom->createElement('small', 'MVP');
                    $mvp = $playerDom->createElement('span');
                    $mvp->setAttribute('class', 'pill-span _noMargin');
                    $mvp->appendChild($small);
                    $playerDom->getElementById('playerLane')->parentNode->appendChild($mvp);
                }

                if ($matchData['matchMode'] !== 'ARAM') {
                    $playerDom->getElementById('playerLane')->nodeValue = $player['lane'];
                    $lane = $player['timeline']['lane'];
                    $role = $player['lane'];
                } else {
                    $laneDom = $playerDom->getElementById('playerLane');
                    $laneDom->parentNode->removeChild($laneDom);
                }

                $players[] = ['dom' => $playerDom, 'lane' => $lane, 'role' => $role];

                $region = new Region($matchData['region']);
                if (isset($player['summonerName'])) {
                    $playerName = new SummonerName($player['summonerName']);
                    $playerLink = $playerDom->createElement('a');
                    $playerLink->setAttribute('href', $this->uriBuilder->createSummonerUri($region, $playerName));
                    $playerLink->setAttribute('id', 'playerName');
                    $node = $playerDom->getElementById('playerName');
                    $node->parentNode->replaceChild($playerLink, $node);
                }

                if ($color === 'purple') {
                    $playerDom->firstChild->setAttribute('class', 'match-timeline-player -mirror');
                }

                $championImage = $playerDom->getElementById('championImage');
                $championImage->setAttribute('src', '//cdn.ganked.net/images/lol/champion/icon/' . $champion['image']['full']);
                $championImage->setAttribute('alt', $champion['name']);

                $playerDom->getElementById('championName')->nodeValue = $champion['name'];
                $playerDom->getElementById('championTitle')->nodeValue = ucfirst($champion['title']);
                $playerDom->getElementById('championLink')->setAttribute('href', $this->uriBuilder->createChampionPageUri($champion['key']));
                $playerDom->getElementById('playerName')->nodeValue = $playerName;

                $goldElement = $playerDom->getElementById('gold');
                $goldElement->nodeValue = (new StatisticNumber($stats['goldEarned']))->getRounded();
                $goldElement->setAttribute('player', $player['participantId']);

                $kills = $stats['kills'];
                $deaths = $stats['deaths'];
                $assists = $stats['assists'];

                $minions = 0;
                if (isset($stats['minionsKilled'])) {
                    $minions = $stats['minionsKilled'];
                }

                if (isset($stats['neutralMinionsKilledEnemyJungle'])) {
                    $minions += $stats['neutralMinionsKilledEnemyJungle'];
                }

                if (isset($stats['neutralMinionsKilledTeamJungle'])) {
                    $minions += $stats['neutralMinionsKilledTeamJungle'];
                }

                foreach($this->items as $key) {
                    if (!isset($stats[$key])) {
                        $item = $playerDom->createElement('timeline-item');
                        $item->setAttribute('class', 'summoner-item');
                        $item->setAttribute('player', $player['participantId']);

                        if ($key === 'item6') {
                            $wardElement = $playerDom->getElementById('ward');
                            $wardElement->appendChild($item);
                            continue;
                        }

                        $playerDom->getElementById('items')->appendChild($item);
                        continue;
                    }

                    $item = $stats[$key];

                    $itemDom = $this->getDomFromTemplate('templates://content/lol/match/item.xhtml');
                    $itemDom->firstChild->setAttribute('player', $player['participantId']);

                    $itemImage = $itemDom->getElementById('itemImage');
                    $itemImage->setAttribute('src', '//cdn.ganked.net/images/lol/item/' . $item['image']['full']);

                    $itemDom->getElementById('itemName')->nodeValue = $item['name'];

                    if (isset($item['plaintext'])) {
                        $itemDom->getElementById('itemDescription')->nodeValue = $item['plaintext'];
                    }

                    if ($key === 'item6') {
                        $wardElement = $playerDom->getElementById('ward');
                        $playerDom->importAndAppendChild($wardElement, $itemDom->firstChild);
                        continue;
                    }

                    $playerDom->importAndAppendChild($playerDom->getElementById('items'), $itemDom->firstChild);
                }

                $minionsElement = $playerDom->getElementById('minions');
                $minionsElement->nodeValue = $minions;
                $minionsElement->setAttribute('player', $player['participantId']);

                $killsElement = $playerDom->getElementById('kills');
                $killsElement->nodeValue = $kills;
                $killsElement->setAttribute('player', $player['participantId']);

                $deathsElement = $playerDom->getElementById('deaths');
                $deathsElement->nodeValue = $deaths;
                $deathsElement->setAttribute('player', $player['participantId']);

                $assistsElement = $playerDom->getElementById('assists');
                $assistsElement->nodeValue = $assists;
                $assistsElement->setAttribute('player', $player['participantId']);
            }

            usort($players, function ($a, $b) {
                if ($a['lane'] === $b['lane']) {
                    return strcasecmp($a['role'], $b['role']);
                } else {
                    return strcasecmp($a['lane'], $b['lane']);
                }
            });

            foreach($players as $player) {
                $content->importAndAppendChild($content->getElementById($color . '-players'), $player['dom']->firstChild);
            }
        }

        /**
         * @return \Ganked\Library\Helpers\DomHelper
         */
        private function renderStats()
        {
            $statsDom = $this->getDomFromTemplate('templates://content/lol/match/stats.xhtml');
            $headerElement = $statsDom->getElementById('header');
            $tableElement = $statsDom->getElementById('table');
            $matchData = $this->getModel()->getMatchData();
            $stats = $matchData['stats'];

            foreach($stats['champions'] as $champion) {
                $championImage = $statsDom->createElement('img');
                $championImage->setAttribute('src', '//cdn.ganked.net/images/lol/champion/icon/' . $champion['image']['full']);
                $championImage->setAttribute('alt', $champion['name']);
                $championImage->setAttribute('class', 'image');

                $championLink = $statsDom->createElement('a');
                $championLink->setAttribute('href', '/games/lol/champions/' . strtolower($champion['key']));
                $championLink->setAttribute('class', 'avatar-box -match-overview');
                $championLink->appendChild($championImage);

                $championDom = $statsDom->createElement('div');
                $championDom->setAttribute('class', 'value');
                $championDom->appendChild($championLink);

                $headerElement->appendChild($championDom);
            }

            $combatTitle = $statsDom->createElement('h4', 'Combat');
            $combatTitle->setAttribute('class', 'title');
            $tableElement->appendChild($combatTitle);

            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('KDA', $stats['kda']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Largest Killing Spree', $stats['largestKillingSpree']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Largest Multi Kill', $stats['largestMultiKill']));
            $statsDom->importAndAppendChild($tableElement, $this->boolRowRenderer->render('First Blood', $stats['firstBloodKill']));
            $statsDom->importAndAppendChild($tableElement, $this->boolRowRenderer->render('First Tower', $stats['firstTower']));
            //$statsDom->importAndAppendChild($tableElement, $this->renderNumbersRow('Total Crowd Control', $stats['totalTimeCrowdControlDealt']));

            $damageDoneTitle = $statsDom->createElement('h4', 'Damage Done');
            $damageDoneTitle->setAttribute('class', 'title');
            $tableElement->appendChild($damageDoneTitle);

            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Damage Dealt To Champions', $stats['totalDamageDealtToChampions']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('True Damage Dealt To Champions', $stats['trueDamageDealtToChampions']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Physical Damage Dealt To Champions', $stats['physicalDamageDealtToChampions']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Magic Damage Dealt To Champions', $stats['magicDamageDealtToChampions']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Largest Critical Strike', $stats['largestCriticalStrike']));

            $damageTakenTitle = $statsDom->createElement('h4', 'Damage Taken &#38; Healed');
            $damageTakenTitle->setAttribute('class', 'title');
            $tableElement->appendChild($damageTakenTitle);

            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Damage Taken', $stats['totalDamageTaken'], true));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Physical Damage Taken', $stats['physicalDamageTaken'], true));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Magic Damage Taken', $stats['magicDamageTaken'], true));

            $laningTitle = $statsDom->createElement('h4', 'Laning');
            $laningTitle->setAttribute('class', 'title');
            $tableElement->appendChild($laningTitle);

            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('CS', $stats['creepScore']));

            if ($this->matchType !== 'ARAM') {
                $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Jungle CS', $stats['neutralMinionsKilledTeamJungle']));
                $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Enemy Jungle CS', $stats['neutralMinionsKilledEnemyJungle']));
            }

            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('CS @ 10', $stats['creepsPerMinDeltas']));

            if ($this->matchType !== 'ARAM') {
                $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('CSD @ 10', $stats['creepsPerMinDeltasDiff']));
            }

            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Gold Earned', $stats['goldEarned']));
            $statsDom->importAndAppendChild($tableElement, $this->numberRowRenderer->render('Inhibitors Destroyed', $stats['inhibitorKills']));

            return $statsDom;
        }

        /**
         * @return \DOMElement
         *
         * @todo figure out how to iterate players only once.
         */
        private function renderPlayers()
        {
            $matchData = $this->getModel()->getMatchData();
            $template = $this->getTemplate();

            $wrap = $template->createElement('section');
            $wrap->setAttribute('class', 'page-wrap -padding');
            $template->getElementById('main')->appendChild($wrap);

            $grid = $template->createElement('div');
            $grid->setAttribute('class', 'match-player-tabs');
            $wrap->appendChild($grid);

            $sidebar = $template->createElement('nav');
            $sidebar->setAttribute('class', 'players');
            $grid->appendChild($sidebar);

            $playersTitle = $sidebar->appendChild($template->createElement('h3', 'Players'));
            $playersTitle->setAttribute('class', 'title');

            $players = $template->createElement('div');
            $players->setAttribute('class', 'content');
            $grid->appendChild($players);

            $spellTooltips = [];

            foreach ($matchData['teams'] as $team) {
                foreach ($team['participants'] as $player) {
                    $summonerName = $player['champion']['name'];
                    $stats = $player['stats'];

                    if (isset($player['summonerName'])) {
                        $summonerName = $player['summonerName'];
                    }

                    $kills = $stats['kills'];
                    $deaths = $stats['deaths'];
                    $assists = $stats['assists'];

                    $summonerAnchor = 'player-' . $player['participantId'];

                    $playerElement = $players->appendChild($template->createElement('gnkd-tab'));
                    $playerElement->setAttribute('id', $summonerAnchor);
                    $playerElement->setAttribute('data-render-keepid', '');
                    $playerElement->setAttribute('group', 'players');
                    $playerElement->setAttribute('hidden', '');

                    $name = $template->createElement('h4', $summonerName);
                    $name->setAttribute('class', '_noMargin');
                    $playerElement->appendChild($name);

                    $playerInfo = $template->createElement('small');
                    $playerInfo->setAttribute('class', 'grid-wrapper -gap _caps');
                    $playerElement->appendChild($playerInfo);

                    $laneWrap = $template->createElement('div');
                    $laneWrap->setAttribute('class', 'item -center');
                    $playerInfo->appendChild($laneWrap);

                    $lane = $template->createElement('p', $player['lane']);
                    $lane->setAttribute('class', '_noMargin _dim');
                    $laneWrap->appendChild($lane);

                    $kdaRatio = $template->createElement('div', (new KDA($kills, $deaths, $assists)) . ' KDA');
                    $kdaRatio->setAttribute('class', 'item -center');
                    $playerInfo->appendChild($kdaRatio);

                    $kda = $template->createElement('div', $kills . '/' . $deaths . '/' . $assists);
                    $kda->setAttribute('class', 'item -center');
                    $playerInfo->appendChild($kda);

                    $goldWrap = $playerInfo->appendChild($template->createElement('div'));
                    $goldWrap->setAttribute('class', 'item -center');

                    $goldNumber = $goldWrap->appendChild($template->createElement('span'));
                    $goldNumber->setAttribute('class', 'match-number');

                    $goldImage = $goldNumber->appendChild($template->createElement('img'));
                    $goldImage->setAttribute('src', '//cdn.ganked.net/images/lol/icon/gold.png');
                    $goldImage->setAttribute('class', 'image');

                    $gold = $goldNumber->appendChild($template->createElement('span', (new StatisticNumber($stats['goldEarned']))->getRounded()));
                    $gold->setAttribute('class', 'text');

                    $graphsGrid = $template->createElement('div');
                    $graphsGrid->setAttribute('class', 'grid-wrapper -gap');
                    $playerElement->appendChild($graphsGrid);

                    $max = [5 => '50', 10 => '114', 15 => '177', 20 => '240'];

                    $earlyCsWrap = $template->createElement('div');
                    $earlyCsWrap->setAttribute('class', 'item');
                    $graphsGrid->appendChild($earlyCsWrap);

                    $earlyCsWrap->appendChild($template->createElement('h6', 'Early CS'));

                    foreach ($player['overTime']['cs'] as $minutes => $cs) {
                        if (!isset($max[$minutes])) {
                            continue;
                        }

                        $subGrid = $template->createElement('div');
                        $subGrid->setAttribute('class', 'grid-wrapper -gap -no-wrap');
                        $earlyCsWrap->appendChild($subGrid);

                        $minutesWrap = $template->createElement('div');
                        $minutesWrap->setAttribute('class', 'item -center match-bar-description');
                        $subGrid->appendChild($minutesWrap);

                        $barWrap = $template->createElement('div');
                        $barWrap->setAttribute('class', 'item -center -grow');
                        $subGrid->appendChild($barWrap);

                        $minutesWrap->appendChild($template->createElement('span', $minutes . ' Mins'));
                        $barWrap->appendChild($template->importNode($this->barGraphRenderer->render($cs, $max[$minutes], $cs), true));
                        $minutesWrap->appendChild($template->createElement('br'));

                        $maxWrap = $subGrid->appendChild($template->createElement('div'));
                        $maxWrap->setAttribute('class', 'item -center');
                        $maxWrap->appendChild($template->createElement('small', $max[$minutes] . ' Max'));
                    }

                    $csSourcesWrap = $template->createElement('div');
                    $csSourcesWrap->setAttribute('class', 'item');
                    $graphsGrid->appendChild($csSourcesWrap);

                    $csSourcesWrap->appendChild($template->createElement('h6', 'CS Sources'));

                    $csSources = $template->createElement('pie-chart');
                    $csSources->setAttribute('donut', '');
                    $csSources->setAttribute('donut-width', '50');
                    $csSources->setAttribute('gnkd-render', '');
                    $csSources->setAttribute('unit', 'CS');

                    $csSourcesLabels = [];
                    $csSourcesSeries = [];

                    if (isset($stats['neutralMinionsKilledEnemyJungle'])) {
                        $csSourcesSeries[] = $stats['neutralMinionsKilledEnemyJungle'];
                        $csSourcesLabels[] = 'Enemy Jungle';
                    }

                    if (isset($stats['neutralMinionsKilledTeamJungle'])) {
                        $csSourcesSeries[] = $stats['neutralMinionsKilledTeamJungle'];
                        $csSourcesLabels[] = 'Neutral Jungle';
                    }

                    $csSourcesSeries[] = $stats['minionsKilled'];
                    $csSourcesLabels[] = 'Lane';

                    $csSources->setAttribute('series', json_encode($csSourcesSeries));
                    $csSources->setAttribute('labels', json_encode($csSourcesLabels));
                    $csSourcesWrap->appendChild($csSources);


                    $playerElement->appendChild($template->createElement('h6', 'Skill Order'));
                    $spells = $player['champion']['spells'];
                    $spellSlots = [];

                    foreach ($spells as $spellIndex => $spell) {
                        $spellWrap = $playerElement->appendChild($template->createElement('div'));
                        $spellWrap->setAttribute('class', 'grid-wrapper -center -gap');

                        $spellImageWrap = $spellWrap->appendChild($template->createElement('div'));
                        $spellImageWrap->setAttribute('class', 'item');

                        $spellImage = $spellImageWrap->appendChild($template->createElement('img'));
                        $spellImage->setAttribute('src', '//cdn.ganked.net/images/lol/spell/' . $spell['image']['full']);
                        $spellImage->setAttribute('class', 'spell-image');
                        $spellImage->setAttribute('alt', $spell['name']);
                        $spellImage->setAttribute('data-info-box', '#spell-' . $spell['key']);

                        $spellTooltips[$spell['key']] = $spell;
                        $spellSlots[$spellIndex + 1] = [];

                        for ($i = 0; $i < 18; $i++) {
                            $slotWrap = $spellWrap->appendChild($template->createElement('div'));
                            $slotWrap->setAttribute('class', 'item');

                            $slot = $slotWrap->appendChild($template->createElement('div'));
                            $slot->setAttribute('class', 'number-slot');

                            $spellSlots[$spellIndex + 1][$i + 1] = $slot;
                        }
                    }

                    if (isset($player['events'])) {
                        $counter = 1;
                        foreach ($player['events'] as $event) {
                            if ($event['eventType'] !== 'SKILL_LEVEL_UP') {
                                continue;
                            }

                            if (!isset($spellSlots[$event['skillSlot']][$counter])) {
                                continue;
                            }
    
                            $slot = $spellSlots[$event['skillSlot']][$counter];
                            $slot->setAttribute('class', 'number-slot -filled');
                            $slot->nodeValue = $counter;
                            $counter++;
                        }
                    }

                    $playerTab = $template->createElement('div');
                    $playerTab->setAttribute('class', 'player');
                    $sidebar->appendChild($playerTab);

                    $playerTabLink = $template->createElement('a');
                    $playerTabLink->setAttribute('href', '#' . $summonerAnchor);
                    $playerTabLink->setAttribute('is', 'tab-link');
                    $playerTabLink->setAttribute('class', 'avatar-box -match-overview');

                    $championImage = $template->createElement('img');
                    $championImage->setAttribute('src', '//cdn.ganked.net/images/lol/champion/icon/' . $player['champion']['image']['full']);
                    $championImage->setAttribute('alt', $summonerName);
                    $championImage->setAttribute('class', 'image');

                    if ($summonerAnchor === 'player-1') {
                        $playerTabLink->setAttribute('class', 'avatar-box -match-overview -active');
                        $playerElement->removeAttribute('hidden');
                    }

                    $playerTabLink->appendChild($championImage);
                    $playerTab->appendChild($playerTabLink);
                }
            }

            foreach ($spellTooltips as $spell) {
                $infoBox = $players->appendChild($template->createElement('info-box'));
                $infoBox->setAttribute('hidden', '');
                $infoBox->setAttribute('data-render-keepid', '');
                $infoBox->setAttribute('id', 'spell-' . $spell['key']);

                $title = $infoBox->appendChild($template->createElement('h4', $spell['name']));
                $title->setAttribute('class', '_no-margin');

                $description = $infoBox->appendChild($template->createElement('p', $spell['sanitizedDescription']));
                $description->setAttribute('class', '_no-margin');
            }
        }
    }
}
