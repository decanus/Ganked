<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\StaticPages
{

    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\MetaTags;

    class StaticPage
    {
        /**
         * @var string
         */
        private $uri;

        /**
         * @var MetaTags
         */
        private $metaTags;

        /**
         * @var DomHelper
         */
        private $template;

        /**
         * @var string
         */
        private $bodyClass;

        /**
         * @param string    $uri
         * @param MetaTags  $metaTags
         * @param DomHelper $template
         * @param string    $bodyClass
         */
        public function __construct($uri, MetaTags $metaTags, DomHelper $template, $bodyClass = '')
        {
            $this->uri = $uri;
            $this->metaTags = $metaTags;
            $this->template = $template;
            $this->bodyClass = $bodyClass;
        }

        /**
         * @return string
         */
        public function getUri()
        {
            return $this->uri;
        }

        /**
         * @return MetaTags
         */
        public function getMetaTags()
        {
            return $this->metaTags;
        }

        /**
         * @return DomHelper
         */
        public function getTemplate()
        {
            return $this->template;
        }

        /**
         * @return string
         */
        public function getBodyClass()
        {
            return $this->bodyClass;
        }
    }
}
