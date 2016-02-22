<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader;

    class MasteriesSnippetRenderer
    {
        /**
         * @var LeagueOfLegendsDataPoolReader
         */
        private $reader;

        /**
         * @param LeagueOfLegendsDataPoolReader $reader
         */
        public function __construct(LeagueOfLegendsDataPoolReader $reader)
        {
            $this->reader = $reader;
        }

        /**
         * @param array $page
         *
         * @return \Ganked\Library\Helpers\DomHelper
         */
        public function render(array $page)
        {
            $trees = $this->reader->getLeagueOfLegendsMasteriesTemplate();
            $treeCounters = ['ferocity' => 0, 'cunning' => 0, 'resolve' => 0];

            if (!isset($page['masteries'])) {
                return $trees;
            }

            foreach($page['masteries'] as $mastery) {
                $page = $trees->query('/div/div/article/div/div/figure[@id="mastery-' . $mastery['id'] . '"]/figcaption/span')
                    ->item(0);

                if ($page === null) {
                    continue;
                }

                $page->nodeValue = $mastery['rank'];

                $item = $trees->query('/div/div/article/div/div/figure[@id="mastery-' . $mastery['id'] . '"]')->item(0);
                $treeName = $item->getAttribute('data-tree-name');
                $prereq = $item->getAttribute('data-prereq');

                $item->setAttribute('class', 'mastery-item -' . $treeName . $prereq);
                $item->removeAttribute('data-tree-name');
                $item->removeAttribute('data-prereq');

                $treeCounters[$treeName] += $mastery['rank'];
            }

            foreach($treeCounters as $name => $count) {
                $trees->query('/div/div/article/header/h4[@data-tree-counter="' . $name . '"]')->item(0)->nodeValue = $count;
            }

            return $trees;
        }
    }
}
