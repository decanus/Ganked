<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Backend\Renderers
{

    use Ganked\Library\DataPool\DataPoolReader;

    class LeagueOfLegendsFreeChampionsRenderer
    {
        /**
         * @var DataPoolReader
         */
        private $dataPoolReader;

        /**
         * @param DataPoolReader $dataPoolReader
         */
        public function __construct(DataPoolReader $dataPoolReader)
        {
            $this->dataPoolReader = $dataPoolReader;
        }

        /**
         * @param \DOMElement $operation
         *
         * @return \DOMElement
         * @throws \OutOfBoundsException
         */
        public function render(\DOMElement $operation)
        {
            $champions = $this->dataPoolReader->getFreeChampionsList();

            $grid = $operation->ownerDocument->createElement('grid');
            $grid->setAttribute('class', 'free-champions');

            foreach ($champions as $champion) {

                if (!$this->dataPoolReader->hasChampionById($champion)) {
                    continue;
                }

                $championName = $this->dataPoolReader->getChampionById($champion);

                $item = $grid->ownerDocument->createElement('div');
                $item->setAttribute('class', 'item');

                $link = $grid->ownerDocument->createElement('a');
                $link->setAttribute('href', '/games/lol/champions/' . strtolower($championName));
                $link->setAttribute('title', $championName);
                $item->appendChild($link);

                $avatarBox = $grid->ownerDocument->createElement('div');
                $avatarBox->setAttribute('class', 'avatar-box -freeChampion');
                $link->appendChild($avatarBox);

                $image = $grid->ownerDocument->createElement('img');
                $image->setAttribute('alt', $championName);
                $image->setAttribute('title', $championName);
                $image->setAttribute('class', 'image');
                $image->setAttribute('src', '//cdn.ganked.net/images/lol/champion/icon/' . $championName . '.png');
                $avatarBox->appendChild($image);

                $grid->insertBefore($item, $grid->firstChild);
            }

            $operation->parentNode->appendChild($grid);
            return $grid;
        }
    }
}
