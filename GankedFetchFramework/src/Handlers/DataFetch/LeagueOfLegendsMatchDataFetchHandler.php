<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Fetch\Handlers\DataFetch
{

    use Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader;
    use Ganked\Library\Generators\ImageUriGenerator;
    use Ganked\Library\ValueObjects\StatisticNumber;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Queries\FetchMatchForRegionQuery;

    class LeagueOfLegendsMatchDataFetchHandler implements DataFetchHandlerInterface
    {
        /**
         * @var FetchMatchForRegionQuery
         */
        private $fetchMatchForRegionQuery;

        /**
         * @var LeagueOfLegendsDataPoolReader
         */
        private $leagueOfLegendsDataPoolReader;

        /**
         * @var ImageUriGenerator
         */
        private $imageUriGenerator;

        /**
         * @param FetchMatchForRegionQuery      $fetchMatchForRegionQuery
         * @param LeagueOfLegendsDataPoolReader $leagueOfLegendsDataPoolReader
         * @param ImageUriGenerator             $imageUriGenerator
         */
        public function __construct(
            FetchMatchForRegionQuery $fetchMatchForRegionQuery,
            LeagueOfLegendsDataPoolReader $leagueOfLegendsDataPoolReader,
            ImageUriGenerator $imageUriGenerator
        )
        {
            $this->fetchMatchForRegionQuery = $fetchMatchForRegionQuery;
            $this->leagueOfLegendsDataPoolReader = $leagueOfLegendsDataPoolReader;
            $this->imageUriGenerator = $imageUriGenerator;
        }

        /**
         * @param AbstractRequest $request
         *
         * @return array
         * @throws \Exception
         */
        public function execute(AbstractRequest $request)
        {
            $data = json_decode($this->fetchMatchForRegionQuery->execute(strtolower($request->getParameter('region')), $request->getParameter('id'))->getBody(), true);
            $timeline = $data['timeline'];

            foreach ($data['participants'] as $participant) {
                $timeline['participants'][$participant['participantId']] = $participant['teamId'];
            }

            foreach ($timeline['frames'] as $frameKey => $frames) {
                if (!isset($frames['participantFrames'])) {
                    continue;
                }

                foreach ($frames['participantFrames'] as $key => $participantFrame) {
                    $participantFrame['currentGold'] = (new StatisticNumber(abs($participantFrame['currentGold'])))->getRounded();
                    $frames['participantFrames'][$key] = $participantFrame;
                }

                if (isset($frames['events'])) {

                    foreach ($frames['events'] as $eventKey => $event) {
                        if ($event['eventType'] === 'ITEM_PURCHASED' && isset($event['itemId'])) {

                            if (!$this->leagueOfLegendsDataPoolReader->hasItem($event['itemId'])) {
                                $frames['events'][$eventKey]['participantId'] = 0;
                                continue;
                            }

                            $item = $this->leagueOfLegendsDataPoolReader->getItem($event['itemId']);
                            $frames['events'][$eventKey]['item']['name'] = $item['name'];
                            $frames['events'][$eventKey]['item']['description'] = $item['sanitizedDescription'];
                            $frames['events'][$eventKey]['item']['image'] = $this->imageUriGenerator->createLeagueOfLegendsItemIconUri($item['image']['full']);

                            $stacks = 0;
                            if (isset($item['stacks'])) {
                                $stacks = $item['stacks'];
                            }
                            
                            $frames['events'][$eventKey]['eventkey'] = $eventKey;
                            $frames['events'][$eventKey]['item']['stacks'] = $stacks;


                            $from = [];
                            if (isset($item['from'])) {
                                $from = $item['from'];
                            }

                            $frames['events'][$eventKey]['item']['from'] = $from;
                        }

                        if ($event['eventType'] === 'ITEM_UNDO' && isset($event['itemAfter'])) {
                            if (!$this->leagueOfLegendsDataPoolReader->hasItem($event['itemAfter'])) {
                                $frames['events'][$eventKey]['participantId'] = 0;
                                continue;
                            }

                            $item = $this->leagueOfLegendsDataPoolReader->getItem($event['itemAfter']);
                            $frames['events'][$eventKey]['itemAfterId'] = $event['itemAfter'];
                            $frames['events'][$eventKey]['itemAfter'] = [];
                            $frames['events'][$eventKey]['itemAfter']['name'] = $item['name'];
                            $frames['events'][$eventKey]['itemAfter']['description'] = $item['sanitizedDescription'];
                            $frames['events'][$eventKey]['itemAfter']['image'] = $this->imageUriGenerator->createLeagueOfLegendsItemIconUri($item['image']['full']);

                            $stacks = 0;
                            if (isset($item['stacks'])) {
                                $stacks = $item['stacks'];
                            }

                            $frames['events'][$eventKey]['itemAfter']['stacks'] = $stacks;
                        }
                    }
                }

                $timeline['frames'][$frameKey] =  $frames;

            }

            return json_encode($timeline);
        }
    }
}
