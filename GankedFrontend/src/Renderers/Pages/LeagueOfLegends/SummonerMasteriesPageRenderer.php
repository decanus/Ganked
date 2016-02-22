<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader;
    use Ganked\Library\Generators\UriGenerator;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Skeleton\Transformations\SnippetTransformation;
    use Ganked\Skeleton\Transformations\TextTransformation;

    class SummonerMasteriesPageRenderer extends AbstractSummonerPageRenderer
    {
        /**
         * @var MasteriesSnippetRenderer
         */
        private $masteriesSnippetRenderer;

        /**
         * @param DomBackend                       $domBackend
         * @param DomHelper                        $template
         * @param SnippetTransformation            $snippetTransformation
         * @param TextTransformation               $textTransformation
         * @param GenericPageRenderer              $genericPageRenderer
         * @param SummonerSidebarRenderer          $summonerSidebarRenderer
         * @param LeagueOfLegendsDataPoolReader    $leagueOfLegendsDataPoolReader
         * @param LeagueOfLegendsSearchBarRenderer $searchBarRenderer
         * @param UriGenerator                     $uriBuilder
         * @param MasteriesSnippetRenderer         $masteriesSnippetRenderer
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
            MasteriesSnippetRenderer $masteriesSnippetRenderer
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
            $this->masteriesSnippetRenderer = $masteriesSnippetRenderer;
        }

        /**
         * @return DomHelper
         */
        protected function renderContent()
        {
            /**
             * @var \Ganked\Frontend\Models\SummonerMasteriesPageModel $model
             */
            $model = $this->getModel();
            $masteries = $model->getMasteries();
            $dom = new DomHelper('<div></div>');

            if ($masteries === null) {
                return new DomHelper('<div />');
            }

            $nav = $dom->createElement('nav');
            $dom->firstChild->appendChild($nav);

            $navList = $dom->createElement('ul');
            $navList->setAttribute('class', 'grid-wrapper -gap');
            $nav->appendChild($navList);

            foreach($masteries['pages'] as $index => $page) {
                $pageElement = $dom->createElement('gnkd-tab');
                $pageElement->setAttribute('class', 'page-section');
                $pageElement->setAttribute('group', 'masteries');
                $pageElement->setAttribute('id', 'page-' . $index);
                $pageElement->setAttribute('data-render-keepid', '');

                $dom->firstChild->appendChild($pageElement);

                $navItem = $dom->createElement('li');
                $navItem->setAttribute('class', 'item');
                $navList->appendChild($navItem);

                $navLink = $dom->createElement('a', 'Mastery Page ' . ($index + 1));
                $navLink->setAttribute('href', '#page-' . $index);
                $navLink->setAttribute('is', 'tab-link');
                $navLink->setAttribute('class', 'link-button');
                $navItem->appendChild($navLink);

                if ($index === 0) {
                    $navLink->setAttribute('class', 'link-button -active');
                }

                if ($index !== 0) {
                    $pageElement->setAttribute('hidden', '');
                }

                if (isset($page['name'])) {
                    $pageElement->appendChild($dom->createElement('h3', $page['name']));
                    $navLink->nodeValue = $page['name'];
                }

                $dom->importAndAppendChild(
                    $pageElement,
                    $this->masteriesSnippetRenderer->render($page)->firstChild
                );
            }

            return $dom;
        }

        /**
         * @return string
         */
        protected function getTitle()
        {
            return 'Masteries';
        }

        /**
         * @return int
         */
        protected function getActiveNavItem()
        {
            return 3;
        }
    }
}
