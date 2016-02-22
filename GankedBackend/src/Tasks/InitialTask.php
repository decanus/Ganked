<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Tasks
{

    use Ganked\Backend\Locators\TaskLocator;
    use Ganked\Backend\Request;
    use Ganked\Library\DataPool\RedisBackend;
    use Ganked\Library\ValueObjects\DataVersion;

    class InitialTask implements TaskInterface
    {
        /**
         * @var TaskLocator
         */
        private $taskLocator;

        /**
         * @var RedisBackend
         */
        private $redisBackend;

        /**
         * @param TaskLocator    $taskLocator
         * @param RedisBackend   $redisBackend
         */
        public function __construct(TaskLocator $taskLocator, RedisBackend $redisBackend)
        {
            $this->taskLocator = $taskLocator;
            $this->redisBackend = $redisBackend;
        }

        /**
         * @param Request $request
         *
         * @throws \InvalidArgumentException
         */
        public function run(Request $request)
        {
            $dataVersion = new DataVersion('now');

            $tasks = [
                new Request(['', 'BuildStaticPage', '--dataVersion=' . $dataVersion]),
                new Request(['', 'LeagueOfLegendsCurrentPatchGet']),
                new Request(['', 'BuildChampionPages', '--dataVersion=' . $dataVersion]),
                new Request(['', 'CounterStrikeAchievementsTemplateBuild']),
            ];

            foreach ($tasks as $task) {
                $this->taskLocator->locate($task)->run($task);
            }

            $oldDataVersion = $this->redisBackend->get('currentDataVersion');
            $this->redisBackend->set('currentDataVersion', (string) $dataVersion);
            $this->redisBackend->delete((string) $oldDataVersion);
        }
    }
}
