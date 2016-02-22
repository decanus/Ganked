<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Tasks
{

    use Ganked\Backend\Builders\ChampionPageBuilder;
    use Ganked\Backend\Builders\ChampionsPageBuilder;
    use Ganked\Backend\Request;
    use Ganked\Backend\Writers\StaticPageWriter;
    use Ganked\Library\DataPool\DataPoolReader;
    use Ganked\Library\ValueObjects\DataVersion;

    class BuildChampionPagesTask implements TaskInterface
    {

        /**
         * @var ChampionsPageBuilder
         */
        private $championsPageBuilder;

        /**
         * @var ChampionPageBuilder
         */
        private $championPageBuilder;

        /**
         * @var DataPoolReader
         */
        private $dataPoolReader;

        /**
         * @var StaticPageWriter
         */
        private $staticPageWriter;

        /**
         * @param ChampionsPageBuilder $championsPageBuilder
         * @param ChampionPageBuilder  $championPageBuilder
         * @param DataPoolReader       $dataPoolReader
         * @param StaticPageWriter     $staticPageWriter
         */
        public function __construct(
            ChampionsPageBuilder $championsPageBuilder,
            ChampionPageBuilder $championPageBuilder,
            DataPoolReader $dataPoolReader,
            StaticPageWriter $staticPageWriter
        )
        {
            $this->championsPageBuilder = $championsPageBuilder;
            $this->championPageBuilder = $championPageBuilder;
            $this->dataPoolReader = $dataPoolReader;
            $this->staticPageWriter = $staticPageWriter;
        }

        /**
         * @param Request $request
         *
         * @throws \Exception
         */
        public function run(Request $request)
        {
            $dataVersion = new DataVersion($request->getParameter('dataVersion'));

            $this->staticPageWriter->write($dataVersion, $this->championsPageBuilder->build());

            $champions = $this->dataPoolReader->getAllChampions();

            foreach ($champions as $champion) {
                $this->staticPageWriter->write(
                    $dataVersion,
                    $this->championPageBuilder->build(json_decode($champion, true))
                );
            }
        }
    }
}
