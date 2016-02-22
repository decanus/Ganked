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

    class LeagueOfLegendsItemsGetTask implements TaskInterface
    {
        /**
         * @var Curl
         */
        private $curl;

        /**
         * @var Uri
         */
        private $leagueOfLegendsItemsDownloadUri;

        /**
         * @var LeagueOfLegendsDataPoolWriter
         */
        private $leagueOfLegendsDataPoolWriter;

        /**
         * @param Curl                          $curl
         * @param Uri                           $leagueOfLegendsItemsDownloadUri
         * @param LeagueOfLegendsDataPoolWriter $leagueOfLegendsDataPoolWriter
         */
        public function __construct(
            Curl $curl,
            Uri $leagueOfLegendsItemsDownloadUri,
            LeagueOfLegendsDataPoolWriter $leagueOfLegendsDataPoolWriter
        )
        {
            $this->curl = $curl;
            $this->leagueOfLegendsItemsDownloadUri = $leagueOfLegendsItemsDownloadUri;
            $this->leagueOfLegendsDataPoolWriter = $leagueOfLegendsDataPoolWriter;
        }

        /**
         * @param Request $request
         */
        public function run(Request $request)
        {
            $items = $this->curl->get($this->leagueOfLegendsItemsDownloadUri)->getDecodedJsonResponse()['data'];

            foreach ($items as $key => $data) {
                $this->leagueOfLegendsDataPoolWriter->setItem($key, json_encode($data));
            }
        }
    }
}
