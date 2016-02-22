<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Renderers
{

    use Ganked\Frontend\Locators\RendererLocator;
    use Ganked\Frontend\Models\StaticPageModel;
    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Skeleton\Transformations\SnippetTransformation;
    use Ganked\Skeleton\Transformations\TextTransformation;

    class StaticPageRenderer extends AbstractPageRenderer
    {
        /**
         * @var RendererLocator
         */
        private $rendererLocator;

        /**
         * @param DomBackend            $domBackend
         * @param DomHelper             $template
         * @param SnippetTransformation $snippetTransformation
         * @param TextTransformation    $textTransformation
         * @param GenericPageRenderer   $genericPageRenderer
         * @param RendererLocator       $rendererLocator
         */
        public function __construct(
            DomBackend $domBackend,
            DomHelper $template,
            SnippetTransformation $snippetTransformation,
            TextTransformation $textTransformation,
            GenericPageRenderer $genericPageRenderer,
            RendererLocator $rendererLocator
        )
        {
            parent::__construct(
                $domBackend,
                $template,
                $snippetTransformation,
                $textTransformation,
                $genericPageRenderer
            );

            $this->rendererLocator = $rendererLocator;
        }

        protected function doRender()
        {
            /**
             * @var $model StaticPageModel
             */
            $model = $this->getModel();

            $template = $this->getTemplate();
            $this->setTitle($model->getMetaTags()->getTitle());
            $snippetTransformation = $this->getSnippetTransformation();
            $snippetTransformation->replaceElementWithId('main', $model->getTemplate());

            $bodyClass = $model->getBodyClass();

            if ($bodyClass !== '') {
                $template->getBody()->setAttribute('class', $bodyClass);
            }


            $paths = explode('/', ltrim($model->getRequestUri()->getPath(), '/'));
            if (isset($paths[1]) && $paths[1] === 'lol' && isset($paths[2])) {
                $snippetTransformation->replaceElementWithId(
                    'header-search',
                    new DomHelper('<operation action="lolSearchBar" />')
                );
            }

            $operations =  $template->getElementsByTagName('operation');

            if ($operations->length !== 0) {

                /**
                 * @var $operation \DomElement
                 */
                foreach ($operations as $operation) {

                    if (!$operation->hasAttribute('action')) {
                        continue;
                    }

                    $operation->parentNode->replaceChild(
                        $template->importNode($this->rendererLocator->locate($operation->getAttribute('action'))->render()->documentElement, true),
                        $operation
                    );

                }

            }

            //@todo:cleanup and move when design has fully passed
            if (isset($_ENV['CF_INSTANCE_INDEX'])) {
                $this->getTextTransformation()->appendTextToId('instance', 'Instance: ' . $_ENV['CF_INSTANCE_INDEX']);
            }

            /**
             * @todo move away, does not belong here
             */
            $this->getTextTransformation()->appendTextToId(
                'responseTime', 'Execution: ' . round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000) . 'ms'
            );

        }
    }
}
