<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Backend\Tasks
{

    use Ganked\Backend\Request;
    use Ganked\Library\Curl\Curl;
    use Ganked\Library\DataPool\LeagueOfLegendsDataPoolWriter;
    use Ganked\Library\ValueObjects\Uri;

    class LeagueOfLegendsSummonerSpellsGetTask implements TaskInterface
    {
        /**
         * @var Uri
         */
        private $summonerSpellsDownloadUri;

        /**
         * @var Curl
         */
        private $curl;

        /**
         * @var LeagueOfLegendsDataPoolWriter
         */
        private $leagueOfLegendsDataPoolWriter;

        /**
         * @param Uri                           $summonerSpellsDownloadUri
         * @param Curl                          $curl
         * @param LeagueOfLegendsDataPoolWriter $leagueOfLegendsDataPoolWriter
         */
        public function __construct(
            Uri $summonerSpellsDownloadUri,
            Curl $curl,
            LeagueOfLegendsDataPoolWriter $leagueOfLegendsDataPoolWriter
        )
        {
            $this->summonerSpellsDownloadUri = $summonerSpellsDownloadUri;
            $this->curl = $curl;
            $this->leagueOfLegendsDataPoolWriter = $leagueOfLegendsDataPoolWriter;
        }


        /**
         * @param Request $request
         */
        public function run(Request $request)
        {
            $spells = $this->curl->get($this->summonerSpellsDownloadUri)->getDecodedJsonResponse()['data'];

            foreach ($spells as $spell) {
                $this->leagueOfLegendsDataPoolWriter->setSummonerSpell($spell['id'], json_encode($spell));
            }
        }
    }
}
