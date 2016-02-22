<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Models
{

    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Skeleton\Models\AbstractPageModel;

    class StaticPageModel extends AbstractPageModel
    {
        /**
         * @var DomHelper
         */
        private $template;

        /**
         * @var string
         */
        private $bodyClass = '';

        /**
         * @param DomHelper $template
         */
        public function setTemplate(DomHelper $template)
        {
            $this->template = $template;
        }

        /**
         * @return DomHelper
         */
        public function getTemplate()
        {
            return $this->template;
        }

        /**
         * @param string $class
         */
        public function setBodyClass($class)
        {
            $this->bodyClass = $class;
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
