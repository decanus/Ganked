<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Tasks
{

    use Ganked\Backend\Locators\TaskLocator;
    use Ganked\Backend\Request;
    use Ganked\Library\Curl\Curl;
    use Ganked\Library\DataPool\DataPoolReader;
    use Ganked\Library\DataPool\DataPoolWriter;
    use Ganked\Library\ValueObjects\Uri;

    class LeagueOfLegendsCurrentPatchGetTask implements TaskInterface
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
        private $leagueOfLegendsVersionListUri;

        /**
         * @var TaskLocator
         */
        private $taskLocator;

        /**
         * @param Curl           $curl
         * @param DataPoolReader $dataPoolReader
         * @param DataPoolWriter $dataPoolWriter
         * @param Uri            $leagueOfLegendsVersionListUri
         * @param TaskLocator    $taskLocator
         */
        public function __construct(
            Curl $curl,
            DataPoolReader $dataPoolReader,
            DataPoolWriter $dataPoolWriter,
            Uri $leagueOfLegendsVersionListUri,
            TaskLocator $taskLocator
        )
        {
            $this->curl = $curl;
            $this->dataPoolReader = $dataPoolReader;
            $this->dataPoolWriter = $dataPoolWriter;
            $this->leagueOfLegendsVersionListUri = $leagueOfLegendsVersionListUri;
            $this->taskLocator = $taskLocator;
        }

        /**
         * @param Request $request
         *
         * @throws \InvalidArgumentException
         */
        public function run(Request $request)
        {
            $currentPatch = $this->curl->get($this->leagueOfLegendsVersionListUri)->getDecodedJsonResponse()[0];

            if ($currentPatch === $this->dataPoolReader->getCurrentLeagueOfLegendsPatch()) {
                return;
            }

            $tasks = [
                new Request(['', 'LeagueOfLegendsItemsGet']),
                new Request(['', 'LeagueOfLegendsChampionsGet']),
                new Request(['', 'LeagueOfLegendsRunesGet']),
                new Request(['', 'LeagueOfLegendsMasteriesTemplateBuild']),
                new Request(['', 'LeagueOfLegendsSummonerSpellsGet']),
            ];

            foreach ($tasks as $task) {
                $this->taskLocator->locate($task)->run($task);
            }

            $this->dataPoolWriter->setCurrentLeagueOfLegendsPatch($currentPatch);
        }
    }
}
