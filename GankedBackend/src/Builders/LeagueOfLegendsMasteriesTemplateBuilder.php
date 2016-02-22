<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Backend\Builders
{

    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\Helpers\DomHelper;

    class LeagueOfLegendsMasteriesTemplateBuilder
    {

        /**
         * @var DomBackend
         */
        private $domBackend;

        /**
         * @param DomBackend $domBackend
         */
        public function __construct(DomBackend $domBackend)
        {
            $this->domBackend = $domBackend;
        }

        /**
         * @param array $info
         *
         * @return DomHelper
         */
        public function build(array $info = [])
        {
            $data = $info['data'];
            $trees = $info['tree'];

            $dom = new DomHelper('<div class="grid-wrapper -gap -type-a"></div>');

            $masteries = [];

            foreach($trees as $treeName => $tree) {
                $treeDom = $this->domBackend->getDomFromXML(__DIR__ . '/../../data/templates/mastery/tree.xhtml');

                $treeDom->getElementById('treeName')->nodeValue = $treeName;
                $treeDom->getElementById('counter')->setAttribute('data-tree-counter', strtolower($treeName));

                $treeDom->getElementById('box')->setAttribute('class', 'mastery-box -' . strtolower($treeName));

                foreach($tree as $row) {
                    $rowDom = new DomHelper('<div class="row"></div>');

                    foreach($row['masteryTreeItems'] as $mastery) {
                        $rowDom->importAndAppendChild(
                            $rowDom->firstChild,
                            $this->renderMastery($mastery, $data, $treeName)->firstChild
                        );
                    }

                    $treeDom->importAndAppendChild($treeDom->getElementById('masteries'), $rowDom->firstChild);
                }

                $masteries[$treeName] = $treeDom;

            }

            $dom->importAndAppendChild($dom->documentElement, $masteries['Ferocity']->firstChild);
            $dom->importAndAppendChild($dom->documentElement, $masteries['Cunning']->firstChild);
            $dom->importAndAppendChild($dom->documentElement, $masteries['Resolve']->firstChild);

            return $dom;
        }

        /**
         * @param null|array $mastery
         * @param array      $data
         * @param string     $treeName
         *
         * @return DomHelper
         */
        private function renderMastery($mastery, array $data, $treeName)
        {
            if ($mastery === null) {
                return new DomHelper('<div class="mastery-item -placeholder"></div>');
            }

            $id = $mastery['masteryId'];
            $masteryInfo = $data[$id];
            $masteryDom = $this->domBackend->getDomFromXML(__DIR__ . '/../../data/templates/mastery/mastery.xhtml');
            $prereq = '';

            if ($mastery['prereq'] > 0) {
                $prereq = ' -prereq';
            }

            $item = $masteryDom->getElementById('item');
            $item->setAttribute('class', 'mastery-item -disabled -' . strtolower($treeName) . $prereq);
            $item->setAttribute('data-tree-name', strtolower($treeName));
            $item->setAttribute('data-prereq', $prereq);

            $image = $masteryDom->getElementById('image');
            $image->setAttribute('src', '//cdn.ganked.net/images/lol/mastery/' . $masteryInfo['image']['full']);
            $image->setAttribute('alt', strip_tags($masteryInfo['name']));

            $masteryDom->query('/figure/figcaption')
                ->item(0)
                ->appendChild($masteryDom->createTextNode($masteryInfo['ranks']));

            $masteryDom->getElementById('name')->nodeValue = $masteryInfo['name'];

            $descriptionElement = $masteryDom->getElementById('description');
            $descriptions = $masteryInfo['sanitizedDescription'];

            if (count($descriptions) === 1) {
                $descriptionElement->appendChild($masteryDom->createElement('p', $descriptions[0]));
            } else {
                foreach ($descriptions as $key => $description) {
                    $descriptionElement->appendChild($masteryDom->createElement('p', ($key + 1) . ': ' . $description));
                }
            }

            $masteryDom->removeAllIds();
            $masteryDom->query('/figure')->item(0)->setAttribute('id', 'mastery-' . $id);

            return $masteryDom;
        }
    }
}
