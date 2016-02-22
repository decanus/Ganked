<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Skeleton\Models\AbstractPageModel;
    use Ganked\Skeleton\Transformations\SnippetTransformation;
    use Ganked\Skeleton\Transformations\TextTransformation;

    abstract class AbstractPageRenderer
    {
        /**
         * @var AbstractPageModel
         */
        private $model;

        /**
         * @var DomBackend
         */
        private $domBackend;

        /**
         * @var DomHelper
         */
        private $template;

        /**
         * @var SnippetTransformation
         */
        private $snippetTransformation;

        /**
         * @var TextTransformation
         */
        private $textTransformation;

        /**
         * @var GenericPageRenderer
         */
        private $genericPageRenderer;

        /**
         * @param DomBackend            $domBackend
         * @param DomHelper             $template
         * @param SnippetTransformation $snippetTransformation
         * @param TextTransformation    $textTransformation
         * @param GenericPageRenderer   $genericPageRenderer
         */
        public function __construct(
            DomBackend $domBackend,
            DomHelper $template,
            SnippetTransformation $snippetTransformation,
            TextTransformation $textTransformation,
            GenericPageRenderer $genericPageRenderer
        )
        {
            $this->domBackend = $domBackend;
            $this->template = $template;
            $this->snippetTransformation = $snippetTransformation;
            $this->textTransformation = $textTransformation;
            $this->genericPageRenderer = $genericPageRenderer;
        }

        /**
         * @param AbstractPageModel $model
         *
         * @return string
         */
        public function render(AbstractPageModel $model)
        {
            $this->model = $model;
            $this->snippetTransformation->setTemplate($this->getTemplate());
            $this->textTransformation->setTemplate($this->getTemplate());
            $this->doRender();
            $this->genericPageRenderer->render($model, $this->getTemplate());
            $this->template->removeAllIds();
            return $this->getTemplate()->saveXML($this->getTemplate(), LIBXML_NOEMPTYTAG);
        }

        /**
         * @return DomHelper
         */
        protected function getTemplate()
        {
            return $this->template;
        }

        /**
         * @param string $filePath
         *
         * @return \Ganked\Library\Helpers\DomHelper
         */
        protected function getDomFromTemplate($filePath)
        {
            return $this->domBackend->getDomFromXML($filePath);
        }

        /**
         * @return AbstractPageModel
         */
        protected function getModel()
        {
            return $this->model;
        }

        /**
         * @param string $title
         */
        protected function setTitle($title)
        {
            $this->getTemplate()->getFirstElementByTagName('title')->nodeValue = $title . ' - Ganked.net';
        }

        /**
         * @param DomHelper $domHelper
         */
        protected function setTemplate(DomHelper $domHelper)
        {
            $this->template = $domHelper;
        }

        /**
         * @return SnippetTransformation
         */
        protected function getSnippetTransformation()
        {
            return $this->snippetTransformation;
        }

        /**
         * @return TextTransformation
         */
        protected function getTextTransformation()
        {
            return $this->textTransformation;
        }

        /**
         * @param bool $bool
         *
         * @return string
         */
        protected function getStringFromBool($bool)
        {
            $string = 'false';
            if ($bool) {
                $string = 'true';
            }

            return $string;
        }

        /**
         * @return DomBackend
         */
        protected function getDomBackend()
        {
            return $this->domBackend;
        }

        abstract protected function doRender();
    }
}
