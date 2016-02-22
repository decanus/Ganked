<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Frontend\DataObjects\Summoner;
    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\Generators\ImageUriGenerator;
    use Ganked\Library\Generators\UriGenerator;
    use Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName;

    class SummonerSidebarRenderer
    {
        /**
         * @var DomBackend
         */
        private $domBackend;

        /**
         * @var UriGenerator
         */
        private $uriGenerator;

        /**
         * @var ImageUriGenerator
         */
        private $imageUriGenerator;

        /**
         * @param DomBackend        $domBackend
         * @param UriGenerator      $uriGenerator
         * @param ImageUriGenerator $imageUriGenerator
         */
        public function __construct(DomBackend $domBackend, UriGenerator $uriGenerator, ImageUriGenerator $imageUriGenerator)
        {
            $this->domBackend = $domBackend;
            $this->uriGenerator = $uriGenerator;
            $this->imageUriGenerator = $imageUriGenerator;
        }

        /**
         * @param Summoner $summoner
         *
         * @param array    $entry
         *
         * @return \Ganked\Library\Helpers\DomHelper
         */
        public function render(Summoner $summoner, $entry = [])
        {
            $summonerDom = $this->domBackend->getDomFromXML('templates://content/lol/summoner/sidebar.xhtml');

            $imageId = $summoner->getIconId();

            if ($imageId > 28 && 500 > $imageId) {
                $imageId = 0;
            }

            $avatar = $summonerDom->getElementById('avatar');
            $avatar->setAttribute('src', '//cdn.ganked.net/images/lol/profileicon/' . $imageId . '.png');
            $avatar->setAttribute('alt', $summoner->getName());

            $summonerDom->getElementById('name')->appendChild($summonerDom->createTextNode($summoner->getName()));
            $summonerDom->getElementById('region')->appendChild($summonerDom->createTextNode(strtoupper($summoner->getRegion())));
            $summonerDom->getElementById('updated')->nodeValue = round($summoner->getTTL() / 60);
            $summonerDom->getElementById('level')->appendChild($summonerDom->createTextNode($summoner->getLevel()));

            if ($entry === [] || !isset($entry['entries'][0])) {
                $ranked = $summonerDom->getElementById('ranked');
                $ranked->parentNode->removeChild($ranked);
            } else {
                $summonerDom->getElementById('leaguePoints')->appendChild($summonerDom->createTextNode($entry['entries'][0]['leaguePoints'] . 'LP'));
                $tier = strtolower($entry['tier']);
                $summonerDom->getElementById('division')->appendChild($summonerDom->createTextNode(ucfirst($tier) . ' ' . $entry['entries'][0]['division']));

                $image = $summonerDom->getElementById('ranked-image');

                $imageUri = '//cdn.ganked.net/images/lol/tier/small/' . $tier;
                if (isset($entry['entries'][0]['division']) && $tier !== 'master' && $tier !== 'challenger') {
                    $imageUri .= '_' . strtolower($entry['entries'][0]['division']);
                }

                $image->setAttribute('src', $imageUri . '.png');
            }

            $summonerName = new SummonerName($summoner->getName());

            $compareButton = $summonerDom->getElementById('compare-button');
            $compareButton->setAttribute('summoner-id', $summoner->getId());
            $compareButton->setAttribute('summoner-info', json_encode([
                'name' => $summoner->getName(),
                'region' => (string) $summoner->getRegion(),
                'key' => $summonerName->getSummonerNameForLink(),
                'image' => $this->imageUriGenerator->createSummonerProfileIconUri($summoner->getIconId()),
                'link' => $this->uriGenerator->createSummonerUri($summoner->getRegion(), $summonerName)
            ]));

            return $summonerDom;
        }
    }
}
