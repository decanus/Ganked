<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Frontend\Models\SummonerRunesPageModel;
    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader;
    use Ganked\Library\Generators\UriGenerator;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Skeleton\Transformations\SnippetTransformation;
    use Ganked\Skeleton\Transformations\TextTransformation;

    class SummonerRunesPagePageRenderer extends AbstractSummonerPageRenderer
    {
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
         * @param SummonerSidebarRenderer $summonerSidebarRenderer
         * @param LeagueOfLegendsDataPoolReader $leagueOfLegendsDataPoolReader
         * @param LeagueOfLegendsSearchBarRenderer $searchBarRenderer
         * @param UriGenerator $uriBuilder
         * @param LeagueOfLegendsRunesSnippetRenderer $leagueOfLegendsRunesSnippetRenderer
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
            UriGenerator $uriBuilder,
            LeagueOfLegendsRunesSnippetRenderer $leagueOfLegendsRunesSnippetRenderer
        )
        {
            parent::__construct(
                $domBackend,
                $template,
                $snippetTransformation,
                $textTransformation,
                $genericPageRenderer,
                $summonerSidebarRenderer,
                $leagueOfLegendsDataPoolReader,
                $searchBarRenderer,
                $uriBuilder
            );

            $this->leagueOfLegendsRunesSnippetRenderer = $leagueOfLegendsRunesSnippetRenderer;
        }

        /**
         * @return DomHelper
         */
        protected function renderContent()
        {
            /**
             * @var $model SummonerRunesPageModel
             */
            $model = $this->getModel();

            if (count($model->getRunes()) === 0) {
                return new DomHelper('<div class="generic-box -no-margin -fit">No runes were found.</div>');
            }

            $dom = new DomHelper('<div></div>');

            $nav = $dom->createElement('nav');
            $dom->firstChild->appendChild($nav);

            $navList = $dom->createElement('ul');
            $navList->setAttribute('class', 'grid-wrapper -gap');
            $nav->appendChild($navList);

            foreach($this->getModel()->getRunes() as $index => $rune) {
                $tab = $dom->createElement('gnkd-tab');
                $tab->setAttribute('group', 'runes');
                $tab->setAttribute('id', 'rune-' . $index);
                $tab->setAttribute('data-render-keepid', '');

                $dom->firstChild->appendChild($tab);

                $navItem = $dom->createElement('li');
                $navItem->setAttribute('class', 'item');
                $navList->appendChild($navItem);

                $navLink = $dom->createElement('a', htmlentities($rune['name']));
                $navLink->setAttribute('href', '#rune-' . $index);
                $navLink->setAttribute('is', 'tab-link');
                $navLink->setAttribute('class', 'link-button');
                $navItem->appendChild($navLink);

                if ($index !== 0) {
                    $tab->setAttribute('hidden', '');
                }

                if ($index === 0) {
                    $navLink->setAttribute('class', 'link-button -active');
                }

                $slotsDom = $this->leagueOfLegendsRunesSnippetRenderer->render($rune['slots'], $rune['name']);

                $dom->importAndAppendChild(
                    $tab,
                    $slotsDom->firstChild
                );
            }

            return $dom;
        }

        /**
         * @return string
         */
        protected function getTitle()
        {
            return 'Runes';
        }

        /**
         * @return int
         */
        protected function getActiveNavItem()
        {
            return 2;
        }
    }
}
