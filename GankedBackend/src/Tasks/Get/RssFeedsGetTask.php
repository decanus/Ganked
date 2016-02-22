<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Backend\Tasks
{

    use Ganked\Backend\Request;
    use Ganked\Library\Curl\Curl;
    use Ganked\Library\DataPool\DataPoolWriter;
    use Ganked\Library\ValueObjects\Uri;

    class RssFeedsGetTask implements TaskInterface
    {
        /**
         * @var Curl
         */
        private $curl;

        /**
         * @var array
         */
        private $uris;

        /**
         * @var DataPoolWriter
         */
        private $dataPoolWriter;

        /**
         * @param Curl           $curl
         * @param array          $uris
         * @param DataPoolWriter $dataPoolWriter
         */
        public function __construct(Curl $curl, array $uris, DataPoolWriter $dataPoolWriter)
        {
            $this->curl = $curl;
            $this->uris = $uris;
            $this->dataPoolWriter = $dataPoolWriter;
        }

        /**
         * @param Request $request
         */
        public function run(Request $request)
        {
            foreach ($this->uris as $game => $uri) {
                $this->curl->getMulti(new Uri($uri), [], $game);
            }

            $responses = $this->curl->sendMultiRequest();

            foreach ($responses as $game => $response) {
                if ($response->getResponseCode() !== 200) {
                    continue;
                }

                $this->dataPoolWriter->setRssFeedForGame($game, $response->getResponseAsDomHelper());
            }
        }
    }
}
