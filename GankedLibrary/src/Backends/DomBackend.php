<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Backends
{

    use Ganked\Library\Helpers\DomHelper;

    class DomBackend
    {
        /**
         * @var FileBackend
         */
        private $fileBackend;

        /**
         * @param FileBackend $fileBackend
         */
        public function __construct(FileBackend $fileBackend)
        {
            $this->fileBackend = $fileBackend;
        }

        /**
         * @param string $path
         *
         * @return DomHelper
         * @throws \Exception
         */
        public function getDomFromXML($path)
        {
            return new DomHelper($this->fileBackend->load($path));
        }

        /**
         * @param string $path
         *
         * @return \XSLTProcessor
         */
        public function getXSL($path)
        {
            $xsl = new \XSLTProcessor;
            $xsl->importStylesheet($this->getDomFromXML($path));
            return $xsl;
        }
    }
}
