<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Transformations
{

    use Ganked\Library\Helpers\DomHelper;

    class SnippetTransformation extends AbstractTransformation
    {
        /**
         * @param string    $id
         * @param DomHelper $snippet
         *
         * @throws \OutOfBoundsException
         */
        public function appendToId($id, DomHelper $snippet)
        {
            $this->queryId($id)->appendChild($this->importNode($snippet));
        }

        /**
         * @param string    $id
         * @param DomHelper $snippet
         *
         * @throws \OutOfBoundsException
         */
        public function replaceElementWithId($id, DomHelper $snippet)
        {
            $node = $this->queryId($id);
            $node->parentNode->replaceChild($this->importNode($snippet), $node);
        }

        /**
         * @param string $id
         *
         * @throws \OutOfBoundsException
         */
        public function removeElementWithId($id)
        {
            $node = $this->queryId($id);
            $node->parentNode->removeChild($node);
        }

        /**
         * @param DomHelper $snippet
         */
        public function appendToMain(DomHelper $snippet)
        {
            $this->getTemplate()->getFirstElementByTagName('main')->appendChild($this->importNode($snippet));
        }

        /**
         * @param string    $id
         * @param DomHelper $snippet
         *
         * @throws \OutOfBoundsException
         */
        public function prependToElementWithId($id, DomHelper $snippet)
        {
            $node = $this->queryId($id);
            $node->insertBefore($this->importNode($snippet), $node->firstChild);
        }

        /**
         * @param string    $id
         * @param DomHelper $snippet
         *
         * @throws \OutOfBoundsException
         */
        public function insertBeforeElementWithId($id, DomHelper $snippet)
        {
            $node = $this->queryId($id);
            $node->parentNode->insertBefore($this->importNode($snippet), $node);
        }
    }
}
