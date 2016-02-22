<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Frontend\DataObjects\Summoner;
    use Ganked\Frontend\Models\AbstractSummonerModel;
    use Ganked\Frontend\Models\SummonerPageModel;
    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\DataObjects\Accounts\AnonymousAccount;
    use Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader;
    use Ganked\Library\Generators\UriGenerator;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName;
    use Ganked\Skeleton\Transformations\SnippetTransformation;
    use Ganked\Skeleton\Transformations\TextTransformation;

    abstract class AbstractSummonerPageRenderer extends AbstractPageRenderer
    {
        /**
         * @var SummonerSidebarRenderer
         */
        private $summonerSidebarRenderer;

        /**
         * @var LeagueOfLegendsDataPoolReader
         */
        private $leagueOfLegendsDataPoolReader;

        /**
         * @var LeagueOfLegendsSearchBarRenderer
         */
        private $searchBarRenderer;

        /**
         * @var UriGenerator
         */
        private $uriBuilder;

        /**
         * @param DomBackend                       $domBackend
         * @param DomHelper                        $template
         * @param SnippetTransformation            $snippetTransformation
         * @param TextTransformation               $textTransformation
         * @param GenericPageRenderer              $genericPageRenderer
         * @param SummonerSidebarRenderer          $summonerSidebarRenderer
         * @param LeagueOfLegendsDataPoolReader    $leagueOfLegendsDataPoolReader
         * @param LeagueOfLegendsSearchBarRenderer $searchBarRenderer
         * @param UriGenerator                       $uriBuilder
         */
        public function __construct(
            DomBackend $domBackend,
            DomHelper $template,
            SnippetTransformation $snippetTransformation,
            TextTransformation $textTransformation,
            GenericPageRenderer $genericPageRenderer,
            SummonerSidebarRenderer $summonerSidebarRenderer,
            LeagueOfLegendsDataPoolReader $leagueOfLegendsDataPoolReader,
            LeagueOfLegendsSearchBarRenderer $searchBarRenderer,
            UriGenerator $uriBuilder
        )
        {
            parent::__construct(
                $domBackend,
                $template,
                $snippetTransformation,
                $textTransformation,
                $genericPageRenderer
            );

            $this->summonerSidebarRenderer = $summonerSidebarRenderer;
            $this->leagueOfLegendsDataPoolReader = $leagueOfLegendsDataPoolReader;
            $this->searchBarRenderer = $searchBarRenderer;
            $this->uriBuilder = $uriBuilder;
        }

        protected function doRender()
        {
            /**
             * @var $model AbstractSummonerModel
             */
            $model = $this->getModel();
            $summoner = $model->getSummoner();

            $snippet = $this->getSnippetTransformation();
            $snippet->appendToMain($this->getDomFromTemplate('templates://content/lol/summoner/page.xhtml'));
            $snippet->replaceElementWithId('summoner-sidebar', $this->summonerSidebarRenderer->render($summoner, $model->getEntry()));
            $snippet->appendToId('content', $this->renderContent());

            $this->setTitle($summoner->getName() . ' - ' . $this->getTitle() . ' - ' . strtoupper($summoner->getRegion()));

            if ($model->getCurrentGame() !== []) {
                $this->getSnippetTransformation()->replaceElementWithId('current-game', $this->renderCurrentGame());
            }

            $snippet->replaceElementWithId('header-search', $this->searchBarRenderer->render($model->getRequestUri()));

            $this->renderMenu();
        }

        /**
         * @return \Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader
         */
        protected function getLeagueOfLegendsDataPoolReader()
        {
            return $this->leagueOfLegendsDataPoolReader;
        }

        private function renderMenu()
        {
            /**
             * @var $model AbstractSummonerModel
             */
            $model = $this->getModel();
            $summoner = $model->getSummoner();
            $name = new SummonerName($summoner->getName());
            $region = $summoner->getRegion();
            $template = $this->getTemplate();

            $base = $this->getUriBuilder()->createSummonerUri($region, $name);

            $template->getElementById('matches')->setAttribute('href', $base);
            $template->getElementById('runes')->setAttribute('href', $base . '/runes');
            $template->getElementById('masteries')->setAttribute('href', $base . '/masteries');
            $template->getElementById('champions')->setAttribute('href', $base . '/champions');

            $active = $this->getActiveNavItem();

            $template->query('//form/input[@name="summonerId"]')->item(0)->setAttribute('value', $summoner->getId());

            foreach($template->query('//form/input[@name="region"]') as $region) {
                $region->setAttribute('value', (string) $summoner->getRegion());
            }

            if ($model->getHasFavouritedSummoner()) {
                $template->query('//form/button//span[@id="favourite-text"]')->item(0)->nodeValue = 'Unfavourite';
                $template->query('//form[@id="favourite-form"]/button')->item(0)->setAttribute('class', '-red -active -block');
                $template
                    ->query('//form[@id="favourite-form"]')
                    ->item(0)
                    ->setAttribute('action', '//post.ganked.net/action/summoner/unfavourite');
            }

            if ($model->getAccount() instanceof AnonymousAccount) {
                $button = $template->query('//button[@id="favourite"]')->item(0);
                $button->setAttribute('data-modal-dialog', '#login');
                $button->removeAttribute('is');

                $template->importAndAppendChild(
                    $template->getElementById('login-inner'),
                    $this->getDomFromTemplate('templates://partials/login.xhtml')->firstChild
                );
            }

            $template
                ->query('//aside/div/nav/a[' . $active . ']')
                ->item(0)
                ->setAttribute('class', 'link -active');
        }

        /**
         * @return DomHelper
         * @throws \OutOfBoundsException
         */
        private function renderCurrentGame()
        {
            /**
             * @var SummonerPageModel $model
             */
            $model = $this->getModel();
            $game = $model->getCurrentGame();

            /**
             * @var Summoner $summoner
             */
            $summoner = $model->getSummoner();
            $box = $this->getDomFromTemplate('templates://content/lol/summoner/current-game.xhtml');
            $startTime = new \DateTime('@' . round($game['gameStartTime'] / 1000));

            $box->getElementById('title')->nodeValue = 'Playing ' . $game['gameMode'];
            $box->getElementById('link')->setAttribute(
                'href',
                $this->getUriBuilder()->createSummonerUri($summoner->getRegion(), new SummonerName($summoner->getName())) . '/current'
            );

            $box->getElementById('startTime')->setAttribute('datetime', $startTime->format(\DateTime::W3C));

            $championId = null;
            foreach($game['participants'] as $player) {
                if ($player['summonerId'] === $model->getSummoner()->getId()) {
                    $championId = $player['championId'];
                }
            }

            $championName = $this->getLeagueOfLegendsDataPoolReader()->getChampionById($championId);
            $champion = $this->getLeagueOfLegendsDataPoolReader()->getChampionByName($championName);

            $image = $box->getElementById('image');
            $image->setAttribute('alt', $champion['name']);
            $image->setAttribute('src', '//cdn.ganked.net/images/lol/champion/icon/' . $champion['image']['full']);

            $box->getElementById('championLink')->setAttribute('href', $this->getUriBuilder()->createChampionPageUri($championName));

            return $box;
        }

        /**
         * @return UriGenerator
         */
        protected function getUriBuilder()
        {
            return $this->uriBuilder;
        }

        /**
         * @return DomHelper
         */
        abstract protected function renderContent();

        /**
         * @return string
         */
        abstract protected function getTitle();

        /**
         * @return int
         */
        abstract protected function getActiveNavItem();
    }
}
