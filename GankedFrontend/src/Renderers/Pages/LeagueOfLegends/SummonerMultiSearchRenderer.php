<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Frontend\Models\SearchPageModel;
    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\StatisticNumber;
    use Ganked\Skeleton\Transformations\SnippetTransformation;
    use Ganked\Skeleton\Transformations\TextTransformation;

    class SummonerMultiSearchRenderer extends AbstractPageRenderer
    {
        /**
         * @var LeagueOfLegendsSearchBarRenderer
         */
        private $leagueOfLegendsSearchBarRenderer;

        /**
         * @param DomBackend                       $domBackend
         * @param DomHelper                        $template
         * @param SnippetTransformation            $snippetTransformation
         * @param TextTransformation               $textTransformation
         * @param GenericPageRenderer              $genericPageRenderer
         * @param LeagueOfLegendsSearchBarRenderer $leagueOfLegendsSearchBarRenderer
         */
        public function __construct(
            DomBackend $domBackend,
            DomHelper $template,
            SnippetTransformation $snippetTransformation,
            TextTransformation $textTransformation,
            GenericPageRenderer $genericPageRenderer,
            LeagueOfLegendsSearchBarRenderer $leagueOfLegendsSearchBarRenderer
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
        }

        protected function doRender()
        {
            $this->setTitle('Multi Search');

            /**
             * @var $model SearchPageModel
             */
            $model = $this->getModel();

            if ($model->getSearchResult() === null) {
                $this->renderPage();
            } else {
                $this->getTemplate()->getElementById('header-search')->setAttribute('id', 'search');
                $this->renderResults();
            }

            if ($model->getSearchResult() !== null) {
            }

            $searchBar = $this->leagueOfLegendsSearchBarRenderer->render($this->getModel()->getRequestUri());

            $all = $searchBar->getElementById('all');
            $all->parentNode->removeChild($all);

            $searchBar->getFirstElementByTagName('input')->setAttribute('is', 'multi-search');

            $searchBar->getElementById('summonerSearchForm')->setAttribute('action', '/games/lol/search/multi');
            $searchBar->getElementById('summonerSearch')->setAttribute('name', 'names');

            $this->getSnippetTransformation()->replaceElementWithId('search', $searchBar);
        }

        private function renderPage()
        {
            $this->getSnippetTransformation()->appendToMain($this->getDomFromTemplate('templates://content/lol/search/multi/content.xhtml'));
        }

        private function renderResults()
        {
            $snippet = $this->getSnippetTransformation();
            $searchResult = $this->getModel()->getSearchResult();

            foreach($searchResult as $id => $summoner) {
                if ($id === 'region') {
                    continue;
                }

                $matches = 0;
                if (isset($summoner['matchlist']['totalGames'])) {
                    $matches = $summoner['matchlist']['totalGames'];
                }

                $role = 'UNKNOWN';
                if (isset($summoner['role'])) {
                    $role = $summoner['role'];
                }

                $summonerDom = $this->getDomFromTemplate('templates://content/lol/search/multi/summoner.xhtml');

                $summonerDom->getElementById('name')->nodeValue = $summoner['name'];
                $summonerDom->getElementById('level')->nodeValue = $summoner['summonerLevel'];
                $summonerDom->getElementById('games')->nodeValue = $matches;
                $summonerDom->getElementById('role')->nodeValue = $role;

                $summonerDom->getElementById('link')->setAttribute('href', '/games/lol/summoners/' . $searchResult['region'] . '/' . strtolower(urlencode(str_replace(' ', '', $summoner['name']))));
                $image = $summonerDom->getElementById('image');
                $image->setAttribute('src', '//cdn.ganked.net/images/lol/profileicon/' . $summoner['profileIconId'] . '.png');
                $image->setAttribute('alt', $summoner['name']);

                if (isset($summoner['champions'])) {
                    foreach($summoner['champions'] as $champion) {
                        $championName = $champion['champion']['name'];

                        $championDom = $this->getDomFromTemplate('templates://content/lol/search/multi/champion.xhtml');
                        $championDom->getElementById('link')->setAttribute('href', '/games/lol/champions/' . strtolower($champion['champion']['key']));

                        $image = $championDom->getElementById('image');
                        $image->setAttribute('alt', $championName);
                        $image->setAttribute('src', '//cdn.ganked.net/images/lol/champion/icon/' . $champion['champion']['key'] . '.png');

                        $championDom->getElementById('kda')->nodeValue = round($champion['kda'], 1);
                        $championDom->getElementById('name')->nodeValue = $championName;
                        $championDom->getElementById('wins')->nodeValue = $champion['wins'];
                        $championDom->getElementById('losses')->nodeValue = $champion['losses'];
                        $championDom->getElementById('kills')->nodeValue = round($champion['kills'], 1);
                        $championDom->getElementById('deaths')->nodeValue = round($champion['deaths'], 1);
                        $championDom->getElementById('assists')->nodeValue = round($champion['assists'], 1);

                        $goldPerGame = new StatisticNumber($champion['goldPerGame']);

                        $championDom->getElementById('goldPerGame')->nodeValue = $goldPerGame->getRounded();
                        $championDom->getElementById('creepScore')->nodeValue = round($champion['creepScore'], 1);

                        $championDom->removeAllIds();
                        $summonerDom->importAndAppendChild(
                            $summonerDom->getElementById('champions'),
                            $championDom->firstChild
                        );
                    }
                }

                $summonerDom->removeAllIds();
                $snippet->appendToMain($summonerDom);
            }
        }
    }
}
