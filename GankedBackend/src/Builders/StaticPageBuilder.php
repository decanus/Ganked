<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Builders
{

    use Ganked\Backend\Locators\RendererLocator;
    use Ganked\Backend\StaticPages\StaticPage;
    use Ganked\Library\Backends\FileBackend;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\MetaTags;
    use Ganked\Skeleton\Transformations\SnippetTransformation;
    use Ganked\Skeleton\Transformations\TextTransformation;

    class StaticPageBuilder
    {
        /**
         * @var FileBackend
         */
        private $fileBackend;

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
         * @var bool
         */
        private $isDevelopment = false;

        /**
         * @var RendererLocator
         */
        private $rendererLocator;


        /**
         * @param FileBackend           $fileBackend
         * @param SnippetTransformation $snippetTransformation
         * @param TextTransformation    $textTransformation
         * @param RendererLocator       $rendererLocator
         * @param bool                  $isDevelopment
         */
        public function __construct(
            FileBackend $fileBackend,
            SnippetTransformation $snippetTransformation,
            TextTransformation $textTransformation,
            RendererLocator $rendererLocator,
            $isDevelopment = false
        )
        {
            $this->fileBackend = $fileBackend;
            $this->snippetTransformation = $snippetTransformation;
            $this->textTransformation = $textTransformation;
            $this->isDevelopment = $isDevelopment;
            $this->rendererLocator = $rendererLocator;
        }

        /**
         * @param string $uri
         * @param string $path
         *
         * @return StaticPage
         * @throws \Exception
         */
        public function build($uri, $path)
        {
            $index = json_decode($this->fileBackend->load('pages://content/' . $path . '/index.json'), true);
            $this->handlePage($path, $index);

            $bodyClass = '';
            if (isset($index['body-class'])) {
                $bodyClass = $index['body-class'];
            }

            return new StaticPage($uri, $this->handleMeta($index['meta']), $this->template, $bodyClass);
        }

        /**
         * @param string $path
         * @param array  $index
         *
         * @throws \Exception
         */
        private function handlePage($path, $index)
        {

            $this->template = new DomHelper($this->fileBackend->load('pages://template.xhtml'));
            $this->snippetTransformation->setTemplate($this->template);
            $this->textTransformation->setTemplate($this->template);

            $body = $this->template->getElementsByTagName('main')->item(0);

            if (isset($index['skeleton'])) {
                $skeleton = new DomHelper($this->fileBackend->load('pages://skeleton/' . $index['skeleton'] . '.xhtml'));
                $this->template->importAndAppendChild($body, $skeleton->documentElement);
            }

            if (!isset($index['content'])) {
                throw new \Exception('Cannot handle page without content');
            }

            foreach ($index['content'] as $type => $snippets) {

                if ($type === 'append') {
                    $this->append($path, $snippets);
                }

                if ($type === 'replace') {
                    $this->replace($path, $snippets);
                }

                if ($type === 'prepend') {
                    $this->prepend($path, $snippets);
                }

                if ($type === 'insertBefore') {
                    $this->insertBefore($path, $snippets);
                }

                if ($type === 'remove') {
                    $this->remove($snippets);
                }
            }

            if (isset($index['text'])) {
                foreach ($index['text'] as $target => $text) {
                    $this->textTransformation->appendTextToId($target, $text);
                }
            }

            if (isset($index['classes'])) {
                $this->handleClasses($index['classes']);
            }

            if (isset($index['attributes'])) {
                $this->handleAttributes($index['attributes']);
            }

            if (isset($index['fetch'])) {
                $this->handleFetch($index['fetch']);
            }

            $this->handleOperations();

            $this->template->removeAllIds();
        }

        private function handleOperations()
        {
            $operations =  $this->template->getElementsByTagName('operation');

            if ($operations->length !== 0) {

                /**
                 * @var $operation \DomElement
                 */
                foreach ($operations as $operation) {

                    if (!$operation->hasAttribute('action') || !$operation->hasAttribute('type')) {
                        continue;
                    }

                    if ($operation->getAttribute('type') !== 'builder') {
                        continue;
                    }

                    $this->rendererLocator->locate($operation->getAttribute('action'))->render($operation);
                    $operation->parentNode->removeChild($operation);
                }
            }
        }

        /**
         * @param string $path
         * @param array  $snippets
         */
        private function insertBefore($path, array $snippets)
        {
            foreach ($snippets as $target => $snippet) {
                $this->snippetTransformation->insertBeforeElementWithId($target, $this->handleContent($path . '/' . $snippet));
            }
        }


        /**
         * @param string $path
         * @param array  $snippets
         */
        private function replace($path, array $snippets)
        {
            foreach ($snippets as $target => $snippet) {
                $this->snippetTransformation->replaceElementWithId($target, $this->handleContent($path . '/' . $snippet));
            }
        }

        /**
         * @param string $path
         * @param array  $snippets
         */
        private function prepend($path, array $snippets)
        {
            foreach ($snippets as $target => $snippet) {
                $this->snippetTransformation->prependToElementWithId($target, $this->handleContent($path . '/' . $snippet));
            }
        }


        /**
         * @param string $path
         * @param array  $snippets
         */
        private function append($path, array $snippets)
        {
            foreach ($snippets as $target => $snippet) {
                $this->snippetTransformation->appendToId($target, $this->handleContent($path . '/' . $snippet));
            }
        }

        /**
         * @param array $snippets
         */
        private function remove(array $snippets)
        {
            foreach ($snippets as $target => $snippet) {
                $this->snippetTransformation->removeElementWithId($target);
            }
        }


        /**
         * @param array $meta
         *
         * @return MetaTags
         */
        private function handleMeta($meta = [])
        {
            $metaTags = new MetaTags;

            if (isset($meta['title'])) {
                $metaTags->setTitle($meta['title']);
            }

            if (isset($meta['description'])) {
                $metaTags->setDescription($meta['description']);
            }

            if (isset($meta['image'])) {
                $metaTags->setImage($meta['image']);
            }

            return $metaTags;
        }

        /**
         * @param array $scripts
         */
        private function handleScripts(array $scripts)
        {
            foreach ($scripts as $scriptSrc) {
                $script = new DomHelper('<script src="/html/js/' . $scriptSrc . '" />');

                $this->template->importAndAppendChild(
                    $this->template->getFirstElementByTagName('body'),
                    $script->documentElement
                );
            }
        }

        /**
         * @param array $fetch
         */
        private function handleFetch(array $fetch)
        {
            foreach ($fetch as $target => $data) {
                /**
                 * @var $targetNode \DomElement
                 */
                $targetNode = $this->template->getElementById($target);

                if ($this->isDevelopment) {
                    $targetNode->setAttribute('href', '//dev.fetch.ganked.net' . $data['href']);
                } else {
                    $targetNode->setAttribute('href', '//fetch.ganked.net' . $data['href']);
                }
            }
        }

        /**
         * @param array $classes
         *
         * @throws \Exception
         */
        private function handleClasses(array $classes)
        {
            foreach ($classes as $targetName => $class) {

                $targetElement = $this->template->getFirstElementByTagName($targetName);
                
                if ($targetElement !== null) {
                    $targetElement->setAttribute('class', $class);
                    continue;
                }

                $targetId = $this->template->getElementById($targetName);

                if ($targetId !== null) {
                    $targetId->setAttribute('class', $class);
                    continue;
                }

                throw new \Exception('Target "' . $targetName . '" not found in page');

            }
        }

        /**
         * @param array $attributes
         *
         * @throws \Exception
         */
        private function handleAttributes(array $attributes)
        {
            foreach ($attributes as $targetName => $attributeList) {

                $target = $this->template->getElementById($targetName);

                if ($target !== null) {

                    foreach ($attributeList as $attr => $value) {
                        $target->setAttribute($attr, $value);
                    }

                    continue;
                }

                throw new \Exception('Target "' . $targetName . '" not found in page');
            }
        }

        /**
         * @param $path
         *
         * @return DomHelper
         */
        private function handleContent($path)
        {
            try {
                $dom = new DomHelper($this->fileBackend->load('pages://content/' . $path));
            } catch (\Exception $e) {
                $error = '<b>Exception:</b> ' . get_class($e) . '<br/><b>Message:</b> ' . $e->getMessage();
                $dom = new DomHelper('<div style="color: red;">' . $error . '</div>');
            }

            return $dom;
        }

    }
}
