<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Queries
{

    use Ganked\Library\Backends\FileBackend;
    use Ganked\Library\Helpers\DomHelper;

    /**
     * @deprecated use DomBackend
     */
    class GetDomFromFileQuery
    {
        /**
         * @var FileBackend
         */
        private $backend;

        /**
         * @param FileBackend $backend
         */
        public function __construct(FileBackend $backend)
        {
            $this->backend = $backend;
        }

        /**
         * @param $filePath
         *
         * @return DomHelper
         * @throws \Exception
         */
        public function execute($filePath)
        {
            return new DomHelper($this->backend->load($filePath));
        }
    }
}
