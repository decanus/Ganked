<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Frontend\DataObjects\CounterStrike\User;
    use Ganked\Frontend\Models\SteamUserPageModel;
    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\DataPool\DataPoolReader;
    use Ganked\Library\Generators\ImageUriGenerator;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\StatisticNumber;
    use Ganked\Skeleton\Transformations\SnippetTransformation;
    use Ganked\Skeleton\Transformations\TextTransformation;

    class CounterStrikeUserPageRenderer extends AbstractPageRenderer
    {
        /**
         * @var ImageUriGenerator
         */
        private $imageUriGenerator;

        /**
         * @var DataPoolReader
         */
        private $dataPoolReader;

        /**
         * @var BarGraphRenderer
         */
        private $barGraphRenderer;

        /**
         * @var DefinitionBlockSnippetRenderer
         */
        private $definitionBlockSnippetRenderer;

        /**
         * @var array
         */
        private $weapons = [
            'knife' => 'Knife',
            'hegrenade' => 'Grenade',
            'glock' => 'Glock-18',
            'deagle' => 'Desert Eagle',
            'elite' => 'Dual Berettas',
            'fiveseven' => 'Five-SeveN',
            'xm1014' => 'XM1014',
            'mac10' => 'MAC-10',
            'ump45' => 'UMP-45',
            'p90' => 'P90',
            'awp' => 'AWP',
            'ak47' => 'AK-47',
            'aug' => 'AUG',
            'famas' => 'Famas',
            'g3sg1' => 'G3SG1',
            'm249' => 'M249',
            'hkp2000' => 'P2000',
            'p250' => 'P250',
            'sg556' => 'SG553',
            'scar20' => 'SCAR-20',
            'ssg08' => 'SSG 08',
            'mp7' => 'MP7',
            'mp9' => 'MP9',
            'nova' => 'Nova',
            'negev' => 'Negev',
            'sawedoff' => 'Sawed-Off',
            'bizon' => 'PP-Bizon',
            'tec9' => 'Tec-9',
            'mag7' => 'MAG-7',
            'm4a1' => 'M4A1',
            'galilar' => 'Galil AR',
            'taser' => 'Taser',
            'scar17' => 'SCAR 17',
            'usp' => 'USP',
            'm3' => 'M3',
            'molotov' => 'Molotov',
            'decoy' => 'Decoy'
        ];

        /**
         * @param DomBackend                     $domBackend
         * @param DomHelper                      $template
         * @param SnippetTransformation          $snippetTransformation
         * @param TextTransformation             $textTransformation
         * @param GenericPageRenderer            $genericPageRenderer
         * @param ImageUriGenerator              $imageUriGenerator
         * @param DataPoolReader                 $dataPoolReader
         * @param BarGraphRenderer               $barGraphRenderer
         * @param DefinitionBlockSnippetRenderer $definitionBlockSnippetRenderer
         */
        public function __construct(
            DomBackend $domBackend,
            DomHelper $template,
            SnippetTransformation $snippetTransformation,
            TextTransformation $textTransformation,
            GenericPageRenderer $genericPageRenderer,
            ImageUriGenerator $imageUriGenerator,
            DataPoolReader $dataPoolReader,
            BarGraphRenderer $barGraphRenderer,
            DefinitionBlockSnippetRenderer $definitionBlockSnippetRenderer
        )
        {
            parent::__construct(
                $domBackend,
                $template,
                $snippetTransformation,
                $textTransformation,
                $genericPageRenderer
            );

            $this->imageUriGenerator = $imageUriGenerator;
            $this->dataPoolReader = $dataPoolReader;
            $this->barGraphRenderer = $barGraphRenderer;
            $this->definitionBlockSnippetRenderer = $definitionBlockSnippetRenderer;
        }

        protected function doRender()
        {
            /**
             * @var $user User
             */
            $user = $this->getModel()->getUser();
            $template = $this->getTemplate();

            $this->setTitle($user->getName());
            $this->renderSearch();

            /*header('Content-Type: application/json');
            echo json_encode($user->getStats());
            exit;*/

            $main = $template->getFirstElementByTagName('main');

            $main->appendChild($this->renderHeader());
            $main->appendChild($this->renderGeneralStats());

            $columns = $main->appendChild($template->createElement('div'));
            $columns->setAttribute('class', 'grid-wrapper -gap -type-a');

            $leftColumn = $columns->appendChild($template->createElement('div'));
            $leftColumn->setAttribute('class', 'item -third');
            $leftColumn->appendChild($this->renderLastMatch());
            $leftColumn->appendChild($this->renderWeapons());


            $rightColumn = $columns->appendChild($template->createElement('div'));
            $rightColumn->setAttribute('class', 'item -twothird');
            $rightColumn->appendChild($this->renderOtherStats());
            $this->renderAchievements($rightColumn);
            $rightColumn->appendChild($this->renderBans());
        }

        /**
         * @return \DOMDocumentFragment
         */
        private function renderHeader()
        {
            $template = $this->getTemplate();
            $fragment = $template->createDocumentFragment();

            /**
             * @var $model SteamUserPageModel
             */
            $model = $this->getModel();
            $user = $model->getUser();

            $header = $fragment->appendChild($template->createElement('header'));
            $header->setAttribute('class', '_gap-after-large');

            $grid = $header->appendChild($template->createElement('div'));
            $grid->setAttribute('class', 'grid-wrapper -larger-gap');

            $avatarWrap = $grid->appendChild($template->createElement('div'));
            $avatarWrap->setAttribute('class', 'item -center');

            $avatarImage = $avatarWrap->appendChild($template->createElement('div'));
            $avatarImage->setAttribute('class', 'avatar-image -large');

            $avatar = $avatarImage->appendChild($template->createElement('img'));
            $avatar->setAttribute('src', $user->getImage());
            $avatar->setAttribute('alt', $user->getName());
            $avatar->setAttribute('class', 'image');

            $nameWrap = $grid->appendChild($template->createElement('div'));
            $nameWrap->setAttribute('class', 'item -center');

            $name = $nameWrap->appendChild($template->createElement('h1', $user->getName()));
            $name->setAttribute('class', '_no-margin');

            $statusWrap = $grid->appendChild($template->createElement('div'));
            $statusWrap->setAttribute('class', 'item -center -grow _right');

            if ($user->getStatus() === 'offline') {
                $lastSeen = $statusWrap->appendChild($template->createElement('h4', 'Last seen '));
                $lastSeen->setAttribute('class', '_no-margin _grey');

                $date = $user->getLastLogOff();
                $lastSeenTime = $lastSeen->appendChild($template->createElement('time', 'on ' . $date->format('M d')));
                $lastSeenTime->setAttribute('datetime', $date->format(\DateTime::W3C));
            } else {
                $status = $statusWrap->appendChild($template->createElement('h4', ucfirst($user->getStatus())));
                $status->setAttribute('class', '_no-margin _green');
            }

            return $fragment;
        }

        /**
         * @return \DOMElement
         */
        private function renderWeapons()
        {
            /**
             * @var SteamUserPageModel $model
             */
            $model = $this->getModel();
            $stats = $model->getUser()->getStats();
            $template = $this->getTemplate();

            $weapons = [];

            foreach($this->weapons as $key => $name) {
                $statsKey = 'total_kills_' . $key;

                if (!isset($stats[$statsKey])) {
                    continue;
                }

                $weapons[$key] = $stats[$statsKey];
            }

            arsort($weapons);

            $weaponsElement = $template->createElement('div');
            $weaponsElement->setAttribute('class', 'generic-box -normal-padding');

            $header = $weaponsElement->appendChild($template->createElement('header'));
            $header->setAttribute('class', 'title-action');

            $title = $header->appendChild($template->createElement('h3', 'Top Weapons'));
            $title->setAttribute('class', 'title');

            $action = $header->appendChild($template->createElement('a', 'Show More'));
            $action->setAttribute('class', 'action');
            $action->setAttribute('is', 'additional-content-toggle-link');
            $action->setAttribute('target-name', 'weapons');
            $action->setAttribute('show-more', 'Show More');
            $action->setAttribute('show-less', 'Show Less');

            $weaponsList = $weaponsElement->appendChild($template->createElement('ul'));
            $weaponsList->setAttribute('class', 'generic-list');

            $moreWeaponsWrap = $weaponsElement->appendChild($template->createElement('additional-content'));
            $moreWeaponsWrap->setAttribute('name', 'weapons');

            $moreWeapons = $moreWeaponsWrap->appendChild($template->createElement('ul'));
            $moreWeapons->setAttribute('class', 'generic-list -continuation');

            $counter = 0;
            $list = $weaponsList;

            foreach($weapons as $weaponKey => $totalKills) {
                $weaponItem = $list->appendChild($template->createElement('li'));
                $weaponItem->setAttribute('data-modal-dialog', '#weapon-' . $weaponKey);

                $weaponGrid = $weaponItem->appendChild($template->createElement('div'));
                $weaponGrid->setAttribute('class', 'grid-wrapper -space-between -larger-gap');

                $weaponIconWrap = $weaponGrid->appendChild($template->createElement('div'));
                $weaponIconWrap->setAttribute('class', 'item -grow -center');

                $weaponIcon = $weaponIconWrap->appendChild($template->createElement('div'));
                $weaponIcon->setAttribute('class', 'weapon-' . $weaponKey);

                $weaponNameWrap = $weaponGrid->appendChild($template->createElement('div'));
                $weaponNameWrap->setAttribute('class', 'item -center');
                $weaponNameWrap->appendChild($template->createElement('span', $this->weapons[$weaponKey]));

                $weaponKills = $weaponGrid->appendChild($template->createElement('div'));
                $weaponKills->setAttribute('class', 'item -center');
                $weaponKills->appendChild($template->createElement('span', $totalKills))->setAttribute('class', '_blue');
                $weaponKills->appendChild($template->createTextNode(' Kills'));

                if ($counter === 4) {
                    $list = $moreWeapons;
                }

                $modalDialog = $weaponsElement->appendChild($template->createElement('modal-dialog'));
                $modalDialog->setAttribute('id', 'weapon-' . $weaponKey);
                $modalDialog->setAttribute('data-render-keepid', '');
                $modalDialog->setAttribute('hidden', '');

                $modalDialogInner = $modalDialog->appendChild($template->createElement('div'));
                $modalDialogInner->setAttribute('class', 'inner');

                $modalDialogHeader = $modalDialogInner->appendChild($template->createElement('header'));
                $modalDialogHeader->setAttribute('class', 'grid-wrapper -space-between -larger-gap');

                $modalDialogTitleWrap = $modalDialogHeader->appendChild($template->createElement('div'));
                $modalDialogTitleWrap->setAttribute('class', 'item -center');

                $modalDialogWeaponWrap = $modalDialogHeader->appendChild($template->createElement('div'));
                $modalDialogWeaponWrap->setAttribute('class', 'item -center');

                $modalDialogWeapon = $modalDialogWeaponWrap->appendChild($template->createElement('span'));
                $modalDialogWeapon->setAttribute('class', 'weapon-' . $weaponKey);

                $modalDialogStats = $modalDialogInner->appendChild($template->createElement('ul'));
                $modalDialogStats->setAttribute('class', 'generic-list -continuation');

                $modalDialogStats->appendChild($this->renderOtherStat('Kills', $totalKills));

                $totalShots = 0;
                if (isset($stats['total_shots_' . $weaponKey])) {
                    $totalShots = $stats['total_shots_' . $weaponKey];
                }
                $modalDialogStats->appendChild($this->renderOtherStat('Shots', $totalShots));

                $totalHits = 0;
                if (isset($stats['total_hits_' . $weaponKey])) {
                    $totalHits = $stats['total_hits_' . $weaponKey];
                }
                $modalDialogStats->appendChild($this->renderOtherStat('Hits', $totalHits));

                try {
                    $accuracyPercentage = round($totalHits / $totalShots * 100, 1);
                } catch(\Exception $e) {
                    $accuracyPercentage = 0;
                }

                $modalDialogStats->appendChild($this->renderOtherStat('Accuracy', $accuracyPercentage . '%'));


                $modalDialogTitleWrap->appendChild($template->createElement('h3', $this->weapons[$weaponKey]))->setAttribute('class', '_no-margin');

                $counter++;
            }

            return $weaponsElement;
        }

        /**
         * @param \DOMNode $gridItem
         */
        private function renderAchievements(\DOMNode $gridItem)
        {
            $template = $this->getTemplate();

            try {
                $template->importAndAppendChild($gridItem, $this->dataPoolReader->getCounterStrikeAchievementsTemplate()->documentElement);
            } catch(\Exception $e) {
                return;
            }

            $model = $this->getModel();
            $user = $model->getUser();

            if (!$user->getAchievements()) {
                return;
            }

            foreach($user->getAchievements() as $achievement) {
                if ($achievement['achieved'] !== 1) {
                    continue;
                }

                $images = $template->query('//li[@data-achievement="' . $achievement['name'] . '"]/img');
                $icon = $template->query('//li[@data-achievement="' . $achievement['name'] . '"]/info-box/div/div[2]/span');

                if ($images->length !== 0) {
                    $image = $images->item(0);
                    $image->setAttribute('src', $this->imageUriGenerator->createCounterStrikeAchievementIconUri($achievement['name']));
                    $image->removeAttribute('class');
                }

                if ($icon->length !== 0) {
                    $icon->item(0)->setAttribute('class', 'octicon octicon-check _green');
                }
            }
        }

        /**
         * @return \DOMDocumentFragment
         */
        private function renderBans()
        {
            $template = $this->getTemplate();
            $fragment = $template->createDocumentFragment();

            $bans = $this->getModel()->getBans();

            $bansDiv = $fragment->appendChild($template->createElement('div'));
            $bansDiv->setAttribute('class', 'generic-box -normal-padding -block _center');

            $bansSpan = $bansDiv->appendChild($template->createElement('span'));

            if (isset($bans['players'][0]['VACBanned']) && $bans['players'][0]['VACBanned']) {
                $bansSpan->appendChild($template->createTextNode(['players'][0]['NumberOfVACBans'] . ' VAC bans on record'));
                $bansSpan->setAttribute('class', '_red');

                return $fragment;
            }

            $bansSpan->appendChild($template->createTextNode('VAC ban record is clear'));
            $bansSpan->setAttribute('class', '_green');

            return $fragment;
        }

        /**
         * @return \DOMDocumentFragment
         */
        private function renderGeneralStats()
        {
            $template = $this->getTemplate();
            $fragment = $template->createDocumentFragment();

            /**
             * @var $user User
             */
            $user = $this->getModel()->getUser();
            $stats = $user->getStats();

            if ($stats === null) {
                $element = $fragment->appendChild($template->createElement('div', 'We couldn\'t get any stats for ' . $user->getName()));
                $element->setAttribute('class', 'generic-box -normal-padding -block');
                return $fragment;
            }

            $box = $fragment->appendChild($template->createElement('div'));
            $box->setAttribute('class', 'generic-box -normal-padding -block');

            $statsWrap = $box->appendChild($template->createElement('div'));
            $statsWrap->setAttribute('class', 'content');

            $firstColumn = $statsWrap->appendChild($template->createElement('ul'));
            $firstColumn->setAttribute('class', 'grid-wrapper -larger-gap -space-between');

            $totalKills = 0;
            if (isset($stats['total_kills'])) {
                $totalKills = $stats['total_kills'];
            }

            $totalDeaths = 0;
            if (isset($stats['total_deaths'])) {
                $totalDeaths = $stats['total_deaths'];
            }

            try {
                $kdRatio = round($totalKills / $totalDeaths, 2);
            } catch(\Exception $e) {
                $kdRatio = 0;
            }

            $firstColumn->appendChild($this->renderStat('KD Ratio', $kdRatio));
            $firstColumn->appendChild($this->renderStat('Kills', $totalKills));


            try {
                $headShotPercentage = round($stats['total_kills_headshot'] / $stats['total_kills'] * 100, 1);
            } catch(\Exception $e) {
                $headShotPercentage = 0;
            }

            $firstColumn->appendChild($this->renderStat('Headshots', $headShotPercentage . '%'));

            try {
                $accuracyPercentage = round($stats['total_shots_hit'] / $stats['total_shots_fired'] * 100, 1);
            } catch(\Exception $e) {
                $accuracyPercentage = 0;
            }

            $firstColumn->appendChild($this->renderStat('Accuracy', $accuracyPercentage . '%'));

            try {
                $winPercentage = round($stats['total_wins'] / $stats['total_rounds_played'] * 100, 1);
            } catch(\Exception $e) {
                $winPercentage = 0;
            }

            $firstColumn->appendChild($this->renderStat('Win', $winPercentage . '%'));

            $mvps = 0;
            if (isset($stats['total_mvps'])) {
                $mvps = $stats['total_mvps'];
            }

            $firstColumn->appendChild($this->renderStat('MVP', $mvps));

            $timePlayed = 0;
            if (isset($stats['total_time_played'])) {
                $timePlayed = $stats['total_time_played'];
            }

            $timePlayedFormatted = round($timePlayed / 3600) . 'h';

            if ($timePlayed > 24 * 3600) {
                $timePlayedFormatted = round($timePlayed / 3600 / 24) . ' days';
            }

            $firstColumn->appendChild($this->renderStat('Time Played', $timePlayedFormatted));

            return $fragment;
        }

        /**
         * @return \DOMElement
         */
        private function renderLastMatch()
        {
            /**
             * @var $user User
             */
            $user = $this->getModel()->getUser();
            $stats = $user->getStats();
            $template = $this->getTemplate();

            $box = $template->createElement('div');
            $box->setAttribute('class', 'generic-box -no-margin -normal-padding -block');
            $box->appendChild($template->createElement('h3', 'Last Match'));

            $roundsWon = 0;
            if (isset($stats['last_match_wins'])) {
                $roundsWon = $stats['last_match_wins'];
            }

            $rounds = 0;
            if (isset($stats['last_match_rounds'])) {
                $rounds = $stats['last_match_rounds'];
            }

            $roundsLost = $rounds - $roundsWon;
            $roundsClass = '_red';

            if ($roundsWon > $roundsLost) {
                $roundsClass = '_green';
            }

            $roundsElement = $box->appendChild($template->createElement('h5', $roundsWon . ' / ' . $rounds . ' rounds'));
            $roundsElement->setAttribute('class', $roundsClass . ' _no-margin');

            $box->appendChild($template->createElement('br'));

            $grid = $box->appendChild($template->createElement('div'));
            $grid->setAttribute('class', 'grid-wrapper -larger-gap -center');

            $kills = 0;
            if (isset($stats['last_match_kills'])) {
                $kills = $stats['last_match_kills'];
            }

            $deaths = 0;
            if (isset($stats['last_match_deaths'])) {
                $deaths = $stats['last_match_deaths'];
            }

            $donutItem = $grid->appendChild($template->createElement('div'));
            $donutItem->setAttribute('class', 'item -center');

            $donut = $donutItem->appendChild($template->createElement('pie-chart'));
            $donut->setAttribute('series', json_encode([$kills, $deaths]));
            $donut->setAttribute('inner-value', 'fraction');
            $donut->setAttribute('color-palette', 'red-green');
            $donut->setAttribute('inner-radius', '0.9');
            $donut->setAttribute('size', '100');

            $killsDeathsItem = $grid->appendChild($template->createElement('div'));
            $killsDeathsItem->setAttribute('class', 'item -center');

            $killsDeathsList = $killsDeathsItem->appendChild($template->createElement('ul'));
            $killsDeathsList->setAttribute('class', 'text-columns -list -single');

            $killsDeathsList->appendChild($this->renderOtherStat('Kills', $kills));
            $killsDeathsList->appendChild($this->renderOtherStat('Deaths', $deaths));

            $box->appendChild($template->createElement('br'));

            $list = $box->appendChild($template->createElement('ul'));
            $list->setAttribute('class', 'text-columns -list -single');

            $mvps = 0;
            if (isset($stats['last_match_mvps'])) {
                $mvps = $stats['last_match_mvps'];
            }
            $list->appendChild($this->renderOtherStat('MVPs', $mvps));

            $damage = 0;
            if (isset($stats['last_match_damage'])) {
                $damage = $stats['last_match_damage'];
            }
            $list->appendChild($this->renderOtherStat('Damage', $damage));

            $moneySpent = 0;
            if (isset($stats['last_match_money_spent'])) {
                $money_spent = $stats['last_match_money_spent'];
            }
            $list->appendChild($this->renderOtherStat('Money Spent', $moneySpent));

            $dominations = 0;
            if (isset($stats['last_match_dominations'])) {
                $dominations = $stats['last_match_dominations'];
            }
            $list->appendChild($this->renderOtherStat('Dominations', $dominations));

            $revenges = 0;
            if (isset($stats['last_match_revenges'])) {
                $revenges = $stats['last_match_revenges'];
            }
            $list->appendChild($this->renderOtherStat('Revenges', $revenges));

            return $box;
        }

        /**
         * @return \DOMElement
         */
        private function renderOtherStats()
        {
            /**
             * @var $user User
             */
            $user = $this->getModel()->getUser();
            $stats = $user->getStats();
            $template = $this->getTemplate();

            $box = $template->createElement('div');
            $box->setAttribute('class', 'generic-box -no-margin -normal-padding -block');
            $box->appendChild($template->createElement('h3', 'Stats'));

            $statsGrid = $box->appendChild($template->createElement('div'));
            $statsGrid->setAttribute('class', 'grid-wrapper -larger-gap -type-a');

            $firstColumnItem = $statsGrid->appendChild($template->createElement('div'));
            $firstColumnItem->setAttribute('class', 'item -third');

            $firstColumnWrap = $firstColumnItem->appendChild($template->createElement('additional-content'));
            $firstColumnWrap->setAttribute('name', 'stats');

            $firstColumn = $firstColumnWrap->appendChild($template->createElement('ul'));
            $firstColumn->setAttribute('class', 'text-columns -list -single');

            $secondColumnItem = $statsGrid->appendChild($template->createElement('div'));
            $secondColumnItem->setAttribute('class', 'item -third');

            $secondColumnWrap = $secondColumnItem->appendChild($template->createElement('additional-content'));
            $secondColumnWrap->setAttribute('name', 'stats');

            $secondColumn = $secondColumnWrap->appendChild($template->createElement('ul'));
            $secondColumn->setAttribute('class', 'text-columns -list -single');

            $thirdColumnItem = $statsGrid->appendChild($template->createElement('div'));
            $thirdColumnItem->setAttribute('class', 'item -third');

            $thirdColumnWrap = $thirdColumnItem->appendChild($template->createElement('additional-content'));
            $thirdColumnWrap->setAttribute('name', 'stats');

            $thirdColumn = $thirdColumnWrap->appendChild($template->createElement('ul'));
            $thirdColumn->setAttribute('class', 'text-columns -list -single');


            $matchesPlayed = 0;
            if (isset($stats['total_matches_played'])) {
                $matchesPlayed = $stats['total_matches_played'];
            }

            $matchesWon = 0;
            if (isset($stats['total_matches_won'])) {
                $matchesWon = $stats['total_matches_won'];
            }

            $matchesLost = $matchesPlayed - $matchesWon;

            $matchesDonutWrap = $firstColumnItem->insertBefore($template->createElement('div'), $firstColumnWrap);
            $matchesDonutWrap->setAttribute('class', '_gap-after-large');

            $matchesDonut = $matchesDonutWrap->appendChild($template->createElement('pie-chart'));
            $matchesDonut->setAttribute('series', json_encode([$matchesWon, $matchesLost]));
            $matchesDonut->setAttribute('inner-value', 'fraction');
            $matchesDonut->setAttribute('color-palette', 'red-green');
            $matchesDonut->setAttribute('inner-radius', '0.9');
            $matchesDonut->setAttribute('size', '100');
            $matchesDonut->setAttribute('class', '_center _gap-after');

            $matchesDonutInfo = $matchesDonutWrap->appendChild($template->createElement('ul'));
            $matchesDonutInfo->setAttribute('class', 'text-columns -list -single');

            $matchesDonutInfo->appendChild($this->renderOtherStat('Matches Won', $matchesWon));
            $matchesDonutInfo->appendChild($this->renderOtherStat('Matches Lost', $matchesLost));

            $firstColumn->appendChild($this->renderOtherStat('Matches Played', $matchesPlayed));

            $matchesDrawn = 0;
            if (isset($stats['total_matches_drawn'])) {
                $matchesDrawn = $stats['total_matches_drawn'];
            }
            $firstColumn->appendChild($this->renderOtherStat('Matches Drawn', $matchesDrawn));

            $totalDeaths = 0;
            if (isset($stats['total_deaths'])) {
                $totalDeaths = $stats['total_deaths'];
            }
            $firstColumn->appendChild($this->renderOtherStat('Total Deaths', $totalDeaths));

            $totalPlantedBombs = 0;
            if (isset($stats['total_planted_bombs'])) {
                $totalPlantedBombs = $stats['total_planted_bombs'];
            }
            $firstColumn->appendChild($this->renderOtherStat('Bombs Planted', $totalPlantedBombs));

            $bombsDefused = 0;
            if (isset($stats['total_defused_bombs'])) {
                $bombsDefused = $stats['total_defused_bombs'];
            }
            $firstColumn->appendChild($this->renderOtherStat('Bombs Defused', $bombsDefused));

            $damage = 0;
            if (isset($stats['total_damage_done'])) {
                $damage = $stats['total_damage_done'];
            }
            $firstColumn->appendChild($this->renderOtherStat('Total Damage', (new StatisticNumber($damage))->getSeparatedThousands() . ' HP'));


            $shotsFired = 0;
            if (isset($stats['total_shots_fired'])) {
                $shotsFired = $stats['total_shots_fired'];
            }

            $shotsHit = 0;
            if (isset($stats['total_shots_hit'])) {
                $shotsHit = $stats['total_shots_hit'];
            }

            $shotsMissed = $shotsFired - $shotsHit;

            $shotsDonutWrap = $secondColumnItem->insertBefore($template->createElement('div'), $secondColumnWrap);
            $shotsDonutWrap->setAttribute('class', '_gap-after-large');

            $shotsDonut = $shotsDonutWrap->appendChild($template->createElement('pie-chart'));
            $shotsDonut->setAttribute('series', json_encode([$shotsHit, $shotsMissed]));
            $shotsDonut->setAttribute('inner-value', 'fraction');
            $shotsDonut->setAttribute('color-palette', 'red-green');
            $shotsDonut->setAttribute('inner-radius', '0.9');
            $shotsDonut->setAttribute('size', '100');
            $shotsDonut->setAttribute('class', '_center _gap-after');

            $shotsDonutInfo = $shotsDonutWrap->appendChild($template->createElement('ul'));
            $shotsDonutInfo->setAttribute('class', 'text-columns -list -single');

            $shotsDonutInfo->appendChild($this->renderOtherStat('Shots Hit', $shotsHit));
            $shotsDonutInfo->appendChild($this->renderOtherStat('Shots Missed', $shotsMissed));

            $secondColumn->appendChild($this->renderOtherStat('Shots Fired', $shotsFired));

            $moneyEarned = 0;
            if (isset($stats['total_money_earned'])) {
                $moneyEarned = $stats['total_money_earned'];
            }
            $secondColumn->appendChild($this->renderOtherStat('Money Earned', $moneyEarned));

            $rescuedHostages = 0;
            if (isset($stats['total_rescued_hostages'])) {
                $rescuedHostages = $stats['total_rescued_hostages'];
            }
            $secondColumn->appendChild($this->renderOtherStat('Hostages Rescued', $rescuedHostages));

            $weaponsDonated = 0;
            if (isset($stats['total_weapons_donated'])) {
                $weaponsDonated = $stats['total_weapons_donated'];
            }
            $secondColumn->appendChild($this->renderOtherStat('Weapons Donated', $weaponsDonated));

            $windowsBroken = 0;
            if (isset($stats['total_broken_windows'])) {
                $windowsBroken = $stats['total_broken_windows'];
            }
            $secondColumn->appendChild($this->renderOtherStat('Windows Broken', $windowsBroken));

            $enemiesBlinded = 0;
            if (isset($stats['total_kills_enemy_blinded'])) {
                $enemiesBlinded = $stats['total_kills_enemy_blinded'];
            }
            $secondColumn->appendChild($this->renderOtherStat('Blind Enemies Killed', $enemiesBlinded));


            $wins = 0;
            if (isset($stats['total_wins'])) {
                $wins = $stats['total_wins'];
            }

            $roundsPlayed = 0;
            if (isset($stats['total_rounds_played'])) {
                $roundsPlayed = $stats['total_rounds_played'];
            }

            $roundsLost = $roundsPlayed - $wins;

            $roundsDonutWrap = $thirdColumnItem->insertBefore($template->createElement('div'), $thirdColumnWrap);
            $roundsDonutWrap->setAttribute('class', '_gap-after-large');

            $roundsDonut = $roundsDonutWrap->appendChild($template->createElement('pie-chart'));
            $roundsDonut->setAttribute('series', json_encode([$wins, $roundsLost]));
            $roundsDonut->setAttribute('inner-value', 'fraction');
            $roundsDonut->setAttribute('color-palette', 'red-green');
            $roundsDonut->setAttribute('inner-radius', '0.9');
            $roundsDonut->setAttribute('size', '100');
            $roundsDonut->setAttribute('class', '_center _gap-after');

            $roundsDonutInfo = $roundsDonutWrap->appendChild($template->createElement('ul'));
            $roundsDonutInfo->setAttribute('class', 'text-columns -list -single');

            $roundsDonutInfo->appendChild($this->renderOtherStat('Rounds Won', $wins));
            $roundsDonutInfo->appendChild($this->renderOtherStat('Rounds Lost', $roundsLost));


            $thirdColumn->appendChild($this->renderOtherStat('Rounds Played', $roundsPlayed));

            $zoomedSnipersKilled = 0;
            if (isset($stats['total_kills_against_zoomed_sniper'])) {
                $zoomedSnipersKilled = $stats['total_kills_against_zoomed_sniper'];
            }
            $thirdColumn->appendChild($this->renderOtherStat('Zoomed Snipers Killed', $zoomedSnipersKilled));

            $dominations = 0;
            if (isset($stats['total_dominations'])) {
                $dominations = $stats['total_dominations'];
            }
            $thirdColumn->appendChild($this->renderOtherStat('Dominations', $dominations));

            $dominationOverkills = 0;
            if (isset($stats['total_domination_overkills'])) {
                $dominationOverkills = $stats['total_domination_overkills'];
            }
            $thirdColumn->appendChild($this->renderOtherStat('Domination Overkills', $dominationOverkills));

            $revenges = 0;
            if (isset($stats['total_revenges'])) {
                $revenges = $stats['total_revenges'];
            }
            $thirdColumn->appendChild($this->renderOtherStat('Revenges', $revenges));

            $killsKnifeFight = 0;
            if (isset($stats['total_kills_knife_fight'])) {
                $killsKnifeFight = $stats['total_kills_knife_fight'];
            }
            $thirdColumn->appendChild($this->renderOtherStat('Knife Fights Won', $killsKnifeFight));

            $showMore = $box->appendChild($template->createElement('a', 'Show more'));
			$showMore->setAttribute('is', 'additional-content-toggle-link');
			$showMore->setAttribute('target-name', 'stats');
			$showMore->setAttribute('show-more', 'Show more');
			$showMore->setAttribute('show-less', 'Show less');

            return $box;
        }

        private function renderSearch()
        {
            $this->getSnippetTransformation()->replaceElementWithId('header-search', $this->getDomFromTemplate('templates://content/cs-go/search.xhtml'));
        }

        /**
         * @param string $label
         * @param string $value
         * @return \DOMDocumentFragment
         */
        private function renderStat($label, $value)
        {
            $template = $this->getTemplate();

            $wrap = $template->createElement('li');
            $wrap->setAttribute('class', 'item -center');

            $template->importAndAppendChild($wrap, $this->definitionBlockSnippetRenderer->render($label, $value)->firstChild);

            return $wrap;
        }

        /**
         * @param string $label
         * @param int $value
         * @return \DOMElement
         */
        private function renderOtherStat($label, $value)
        {
            $template = $this->getTemplate();

            if (is_int($value)) {
                $value = (new StatisticNumber($value))->getSeparatedThousands();
            }

            $grid = $template->createElement('li');
            $grid->setAttribute('class', 'grid-wrapper -no-wrap -space-between -larger-gap');

            $labelWrap = $grid->appendChild($template->createElement('span', $label));
            $labelWrap->setAttribute('class', 'item -grow');

            $valueWrap =  $grid->appendChild($template->createElement('span'));
            $valueWrap->setAttribute('class', 'item');

            $valueElement = $valueWrap->appendChild($template->createElement('span', $value));
            $valueElement->setAttribute('class', '_blue');

            return $grid;
        }
    }
}
