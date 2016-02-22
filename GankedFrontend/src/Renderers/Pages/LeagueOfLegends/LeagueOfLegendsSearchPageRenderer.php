<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Renderers
{

    use Ganked\Frontend\Models\LeagueOfLegendsSearchPageModel;
    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Skeleton\Transformations\SnippetTransformation;
    use Ganked\Skeleton\Transformations\TextTransformation;

    class LeagueOfLegendsSearchPageRenderer extends AbstractPageRenderer
    {
        /**
         * @var SummonerSnippetRenderer
         */
        private $summonerSnippetRenderer;

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
         * @param SummonerSnippetRenderer          $summonerSnippetRenderer
         * @param LeagueOfLegendsSearchBarRenderer $searchBarRenderer
         */
        public function __construct(
            DomBackend $domBackend,
            DomHelper $template,
            SnippetTransformation $snippetTransformation,
            TextTransformation $textTransformation,
            GenericPageRenderer $genericPageRenderer,
            SummonerSnippetRenderer $summonerSnippetRenderer,
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

            $this->summonerSnippetRenderer = $summonerSnippetRenderer;
            $this->searchBarRenderer = $searchBarRenderer;
        }


        protected function doRender()
        {
            /**
             * @var $model LeagueOfLegendsSearchPageModel
             */
            $model = $this->getModel();

            $this->setTitle('Search');

            if ($model->getSearchResult() === null) {
                $this->renderContent();
            } else {
                $this->getTemplate()->getElementById('header-search')->setAttribute('id', 'search');
                $this->renderSearchResults();
                $this->renderFavourites();
            }

            $this->getSnippetTransformation()->replaceElementWithId(
                'search',
                $this->searchBarRenderer->render($this->getModel()->getRequestUri())
            );
        }

        private function renderContent()
        {
            $this->getSnippetTransformation()->appendToMain($this->getDomBackend()->getDomFromXML('templates://content/lol/search/content.xhtml'));
        }

        private function renderFavourites()
        {
            /**
             * @var $model LeagueOfLegendsSearchPageModel
             */
            $model = $this->getModel();
            $template = $this->getTemplate();

            $favourites = $model->getFavouriteSummoners();
            if (empty($favourites)) {
                return;
            }

            $main = $template->getFirstElementByTagName('main');

            $title = $template->createElement('h3', 'Favourites');
            $main->appendChild($title);

            $wrapper = $template->createElement('div');
            $wrapper->setAttribute('class', 'grid-wrapper -gap -type-a');
            $main->appendChild($wrapper);

            foreach ($favourites as $favourite) {
                $template->importAndAppendChild($wrapper, $this->summonerSnippetRenderer->render($favourite)->documentElement);
            }
        }

        private function renderSearchResults()
        {
            /**
             * @var $model LeagueOfLegendsSearchPageModel
             */
            $model = $this->getModel();
            $template = $this->getTemplate();

            $main = $template->getFirstElementByTagName('main');

            $title = $template->createElement('h1', 'Summoner Search');
            $main->appendChild($title);

            $container = $template->createElement('div');
            $container->setAttribute('class', 'grid-wrapper -gap -type-a');
            $container->setAttribute('id', 'container');
            $main->appendChild($container);

            foreach ($model->getSearchResult() as $region => $result) {
                if ($result === null || $result === 'null' || $result === []) {
                    continue;
                }

                $result['region'] = $region;

                $snippet = $this->summonerSnippetRenderer->render($result);
                $snippet->firstChild->setAttribute('class', 'item -quarter -flex');
                $this->getSnippetTransformation()->appendToId('container', $snippet);
            }

            if ($container->childNodes->length === 0) {
                $container->parentNode->removeChild($container);
                $main->appendChild($template->createElement('h3', 'No summoners found!'));
            }
        }
    }
}
