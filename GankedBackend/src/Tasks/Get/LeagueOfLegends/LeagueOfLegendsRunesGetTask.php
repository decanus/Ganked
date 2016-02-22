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

    class LeagueOfLegendsRunesGetTask implements TaskInterface
    {
        /**
         * @var Uri
         */
        private $runesDownloadUri;

        /**
         * @var Curl
         */
        private $curl;

        /**
         * @var LeagueOfLegendsDataPoolWriter
         */
        private $leagueOfLegendsDataPoolWriter;

        /**
         * @param Uri                           $runesDownloadUri
         * @param Curl                          $curl
         * @param LeagueOfLegendsDataPoolWriter $leagueOfLegendsDataPoolWriter
         */
        public function __construct(
            Uri $runesDownloadUri,
            Curl $curl,
            LeagueOfLegendsDataPoolWriter $leagueOfLegendsDataPoolWriter
        )
        {
            $this->runesDownloadUri = $runesDownloadUri;
            $this->curl = $curl;
            $this->leagueOfLegendsDataPoolWriter = $leagueOfLegendsDataPoolWriter;
        }


        /**
         * @param Request $request
         */
        public function run(Request $request)
        {
            $runes = $this->curl->get($this->runesDownloadUri)->getDecodedJsonResponse()['data'];

            foreach ($runes as $key => $rune) {
                $this->leagueOfLegendsDataPoolWriter->setRune($key, json_encode($rune));
            }
        }
    }
}
