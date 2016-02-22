<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Tasks
{

    use Ganked\Backend\Builders\StaticPageBuilder;
    use Ganked\Backend\Request;
    use Ganked\Backend\Writers\StaticPageWriter;
    use Ganked\Library\Backends\FileBackend;
    use Ganked\Library\ValueObjects\DataVersion;

    class BuildStaticPageTask implements TaskInterface
    {
        /**
         * @var StaticPageBuilder
         */
        private $builder;

        /**
         * @var StaticPageWriter
         */
        private $staticPageWriter;

        /**
         * @var FileBackend
         */
        private $fileBackend;

        /**
         * @param StaticPageBuilder $builder
         * @param StaticPageWriter  $staticPageWriter
         * @param FileBackend       $fileBackend
         */
        public function __construct(
            StaticPageBuilder $builder,
            StaticPageWriter $staticPageWriter,
            FileBackend $fileBackend
        )
        {
            $this->builder = $builder;
            $this->staticPageWriter = $staticPageWriter;
            $this->fileBackend = $fileBackend;
        }

        /**
         * @param Request $request
         *
         * @throws \Exception
         */
        public function run(Request $request)
        {
            $pages = json_decode($this->fileBackend->load(__DIR__ . '/../../../GankedTemplates/templates/pages.json'), true);

            $dataVersion = new DataVersion($request->getParameter('dataVersion'));
            foreach ($pages as $uri => $path) {
                $this->staticPageWriter->write($dataVersion, $this->builder->build($uri, $path));
            }
        }
    }
}
