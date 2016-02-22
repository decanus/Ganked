<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Tasks
{

    use Ganked\Backend\Mappers\LeagueOfLegendsLeaderboardMapper;
    use Ganked\Backend\Request;
    use Ganked\Backend\Writers\LeagueOfLegendsLeaderboardWriter;
    use Ganked\Library\Curl\Curl;
    use Ganked\Library\ValueObjects\Uri;

    class LeagueOfLegendsChallengerLeaderboardsGetTask implements TaskInterface
    {
        /**
         * @var Curl
         */
        private $curl;

        /**
         * @var string
         */
        private $uri;

        /**
         * @var LeagueOfLegendsLeaderboardMapper
         */
        private $leagueOfLegendsLeaderboardMapper;

        /**
         * @var LeagueOfLegendsLeaderboardWriter
         */
        private $leagueOfLegendsLeaderboardWriter;

        /**
         * @param Curl                             $curl
         * @param string                           $uri
         * @param LeagueOfLegendsLeaderboardMapper $leagueOfLegendsLeaderboardMapper
         * @param LeagueOfLegendsLeaderboardWriter $leagueOfLegendsLeaderboardWriter
         */
        public function __construct(
            Curl $curl,
            $uri,
            LeagueOfLegendsLeaderboardMapper $leagueOfLegendsLeaderboardMapper,
            LeagueOfLegendsLeaderboardWriter $leagueOfLegendsLeaderboardWriter
        )
        {
            $this->curl = $curl;
            $this->uri = $uri;
            $this->leagueOfLegendsLeaderboardMapper = $leagueOfLegendsLeaderboardMapper;
            $this->leagueOfLegendsLeaderboardWriter = $leagueOfLegendsLeaderboardWriter;
        }

        /**
         * @param Request $request
         */
        public function run(Request $request)
        {
            $regions = ['br', 'eune', 'euw', 'kr', 'lan', 'las', 'na', 'oce', 'ru', 'tr'];

            foreach ($regions as $region) {
                $this->curl->getMulti(new Uri(sprintf($this->uri, $region)), [], $region);
            }

            $responses = $this->curl->sendMultiRequest();

            foreach ($responses as $region => $response) {
                $data = $this->leagueOfLegendsLeaderboardMapper->map(
                    $region,
                    'challenger',
                    $response->getDecodedJsonResponse()
                );

                $this->leagueOfLegendsLeaderboardWriter->write($data);
            }

        }
    }
}
