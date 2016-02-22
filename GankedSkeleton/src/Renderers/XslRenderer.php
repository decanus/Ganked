<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Renderers
{

    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\Helpers\DomHelper;

    class XslRenderer
    {
        /**
         * @var DomBackend
         */
        private $domBackend;

        /**
         * @param DomBackend $domBackend
         */
        public function __construct(DomBackend $domBackend)
        {
            $this->domBackend = $domBackend;
        }

        /**
         * @param string    $xslPath
         * @param DomHelper $domHelper
         *
         * @return DomHelper
         */
        public function render($xslPath, DomHelper $domHelper)
        {
            return new DomHelper($this->domBackend->getXSL($xslPath)->transformToXml($domHelper));
        }
    }
}
