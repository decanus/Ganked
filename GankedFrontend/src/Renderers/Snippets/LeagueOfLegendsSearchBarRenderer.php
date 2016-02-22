<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Frontend\Queries\FetchDefaultLeagueOfLegendsRegionFromSessionQuery;
    use Ganked\Frontend\Queries\HasDefaultLeagueOfLegendsRegionFromSessionQuery;
    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\ValueObjects\Uri;

    class LeagueOfLegendsSearchBarRenderer
    {
        /**
         * @var DomBackend
         */
        private $domBackend;

        /**
         * @var FetchDefaultLeagueOfLegendsRegionFromSessionQuery
         */
        private $fetchDefaultLeagueOfLegendsRegionFromSessionQuery;

        /**
         * @var HasDefaultLeagueOfLegendsRegionFromSessionQuery
         */
        private $hasDefaultLeagueOfLegendsRegionFromSessionQuery;

        /**
         * @param DomBackend                                        $domBackend
         * @param FetchDefaultLeagueOfLegendsRegionFromSessionQuery $fetchDefaultLeagueOfLegendsRegionFromSessionQuery
         * @param HasDefaultLeagueOfLegendsRegionFromSessionQuery   $hasDefaultLeagueOfLegendsRegionFromSessionQuery
         */
        public function __construct(
            DomBackend $domBackend,
            FetchDefaultLeagueOfLegendsRegionFromSessionQuery $fetchDefaultLeagueOfLegendsRegionFromSessionQuery,
            HasDefaultLeagueOfLegendsRegionFromSessionQuery $hasDefaultLeagueOfLegendsRegionFromSessionQuery
        )
        {
            $this->domBackend = $domBackend;
            $this->hasDefaultLeagueOfLegendsRegionFromSessionQuery = $hasDefaultLeagueOfLegendsRegionFromSessionQuery;
            $this->fetchDefaultLeagueOfLegendsRegionFromSessionQuery = $fetchDefaultLeagueOfLegendsRegionFromSessionQuery;
        }

        /**
         * @param Uri $uri
         *
         * @return \Ganked\Library\Helpers\DomHelper
         */
        public function render(Uri $uri = null)
        {
            $form = $this->domBackend->getDomFromXML('templates://content/lol/search.xhtml');

            $region = '';
            if ($uri !== null) {

                if ($uri->hasParameter('name')) {
                    $form->query('/div/div/div/form/div/div/div/div/label/input')->item(0)->setAttribute('value', $uri->getParameter('name'));
                }

                if ($uri->hasParameter('names')) {
                    $form->query('/div/div/div/form/div/div/div/div/label/input')->item(0)->setAttribute('value', $uri->getParameter('names'));
                }

                if ($uri->hasParameter('region')) {
                    $region = $uri->getParameter('region');
                }
            }

            if ($region === '' && $this->hasDefaultLeagueOfLegendsRegionFromSessionQuery->execute()) {
                $region = (string) $this->fetchDefaultLeagueOfLegendsRegionFromSessionQuery->execute();
            }

            if ($region !== '') {
                $form->query('/div/div/div/form/div/div/div/div/label/select/option[@value="' . $region . '"]')->item(0)->setAttribute('selected', '');
            }

            return $form;
        }
    }
}
