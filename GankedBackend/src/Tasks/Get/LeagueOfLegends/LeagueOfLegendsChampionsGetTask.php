<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Backend\Tasks
{

    use Ganked\Backend\Request;
    use Ganked\Library\Curl\Curl;
    use Ganked\Library\DataPool\DataPoolReader;
    use Ganked\Library\DataPool\DataPoolWriter;
    use Ganked\Library\ValueObjects\Uri;

    class LeagueOfLegendsChampionsGetTask implements TaskInterface
    {
        /**
         * @var Curl
         */
        private $curl;

        /**
         * @var DataPoolReader
         */
        private $dataPoolReader;

        /**
         * @var DataPoolWriter
         */
        private $dataPoolWriter;

        /**
         * @var Uri
         */
        private $championsListDownloadUri;

        /**
         * @var Uri
         */
        private $championDownloadUri;

        /**
         * @param Curl           $curl
         * @param DataPoolReader $dataPoolReader
         * @param DataPoolWriter $dataPoolWriter
         * @param Uri            $championsListDownloadUri
         * @param Uri            $championDownloadUri
         */
        public function __construct(
            Curl $curl,
            DataPoolReader $dataPoolReader,
            DataPoolWriter $dataPoolWriter,
            Uri $championsListDownloadUri,
            Uri $championDownloadUri
        )
        {
            $this->curl = $curl;
            $this->dataPoolReader = $dataPoolReader;
            $this->dataPoolWriter = $dataPoolWriter;
            $this->championsListDownloadUri = $championsListDownloadUri;
            $this->championDownloadUri = $championDownloadUri;
        }

        /**
         * @param Request $request
         *
         * @throws \Exception
         */
        public function run(Request $request)
        {
            $champions = $this->curl->get($this->championsListDownloadUri)->getDecodedJsonResponse();

            foreach ($champions['data'] as $champion) {
                $this->curl->getMulti(new Uri(sprintf((string) $this->championDownloadUri, $champion['id'])));
            }

            $championResponses = $this->curl->sendMultiRequest();

            foreach ($championResponses as $championResponse) {
                $champion = $championResponse->getDecodedJsonResponse();
                $this->dataPoolWriter->appendLeagueOfLegendsChampionToList($champion['id'], $champion['key']);
                $this->dataPoolWriter->setLeagueOfLegendsChampionData($champion['key'], $championResponse->getRawResponseBody());
            }
        }
    }
}
