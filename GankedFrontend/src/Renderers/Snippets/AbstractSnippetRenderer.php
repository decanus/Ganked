<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Skeleton\Models\AbstractPageModel;

    abstract class AbstractSnippetRenderer
    {
        /**
         * @var AbstractPageModel
         */
        private $model;

        /**
         * @var DomHelper
         */
        private $template;

        /**
         * @param AbstractPageModel $model
         * @param DomHelper         $template
         */
        public function render(AbstractPageModel $model, DomHelper $template)
        {
            $this->model = $model;
            $this->template = $template;

            $this->doRender();
        }

        abstract protected function doRender();

        /**
         * @return AbstractPageModel
         */
        protected function getModel()
        {
            return $this->model;
        }

        /**
         * @return DomHelper
         */
        protected function getTemplate()
        {
            return $this->template;
        }
    }
}
