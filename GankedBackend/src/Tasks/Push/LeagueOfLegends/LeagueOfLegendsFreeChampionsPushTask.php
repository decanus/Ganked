<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Backend\Tasks
{

    use Ganked\Backend\Request;
    use Ganked\Library\DataPool\DataPoolWriter;
    use Ganked\Skeleton\Gateways\LoLGateway;

    class LeagueOfLegendsFreeChampionsPushTask implements TaskInterface
    {
        /**
         * @var LoLGateway
         */
        private $loLGateway;

        /**
         * @var DataPoolWriter
         */
        private $dataPoolWriter;

        /**
         * @param LoLGateway     $loLGateway
         * @param DataPoolWriter $dataPoolWriter
         */
        public function __construct(LoLGateway $loLGateway, DataPoolWriter $dataPoolWriter)
        {
            $this->loLGateway = $loLGateway;
            $this->dataPoolWriter = $dataPoolWriter;
        }

        /**
         * @param Request $request
         */
        public function run(Request $request)
        {
            $champions = json_decode($this->loLGateway->getFreeChampions()->getBody(), true)['champions'];
            $this->dataPoolWriter->setFreeChampions(array_column($champions, 'id'));
        }
    }
}
