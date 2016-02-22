<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Backends\DomBackend;

    class TrackingSnippetRenderer extends AbstractSnippetRenderer
    {
        /**
         * @var DomBackend
         */
        private $domBackend;

        /**
         * @var bool
         */
        private $isTrackingEnabled;

        /**
         * @param DomBackend $domBackend
         * @param bool       $isTrackingEnabled
         */
        public function __construct(DomBackend $domBackend, $isTrackingEnabled = true)
        {
            $this->domBackend = $domBackend;
            $this->isTrackingEnabled = $isTrackingEnabled;
        }

        protected function doRender()
        {
            if ($this->isTrackingEnabled) {
                $template = $this->getTemplate();

                $template->importAndAppendChild(
                    $template->getFirstElementByTagName('body'),
                    $this->domBackend->getDomFromXML('templates://tracking/googleAnalytics.xml')->firstChild
                );
            }
        }
    }
}
