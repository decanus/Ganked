<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Helpers
{

    use DOMXPath;

    class DomHelper extends \DOMDocument
    {
        /**
         * @var DomXPath
         */
        private $xpath;

        /**
         * @param string $contents
         */
        public function __construct($contents = '')
        {
            if ($contents !== '') {
                $this->loadXML($contents);
            }
        }

        /**
         * @param string $query
         *
         * @return \DOMNodeList
         */
        public function query($query)
        {
            if ($this->xpath === null) {
                $this->xpath = new DOMXPath($this);
            }

            return $this->xpath->query($query);
        }

        /**
         * @param string $name
         *
         * @return \DOMElement
         */
        public function getFirstElementByTagName($name)
        {
            return $this->getElementsByTagName($name)->item(0);
        }

        /**
         * @param string $elementId
         *
         * @return \DOMElement
         */
        public function getElementById($elementId)
        {
            return $this->query("//*[@id='" . $elementId . "']")->item(0);
        }

        /**
         * @param string $elementId
         *
         * @return bool
         */
        public function hasElementById($elementId)
        {
            return $this->query("//*[@id='" . $elementId . "']")->item(0) !== null;
        }

        /**
         * @param string $name
         * @param string $content
         *
         * @return \DOMNode
         */
        public function appendElement($name, $content = null)
        {
            return $this->appendChild(
                $this->createElement($name, $content)
            );
        }

        /**
         * @param \DOMNode $targetNode
         * @param \DOMNode $newNode
         */
        public function importAndAppendChild(\DOMNode $targetNode, \DOMNode $newNode)
        {
            $targetNode->appendChild($this->importNode($newNode, true));
        }

        /**
         * @return \DOMNode
         */
        public function getBody()
        {
            return $this->getElementsByTagName('body')->item(0);
        }

        /**
         * @param DomHelper $domHelper
         *
         * @return \DOMDocumentFragment
         */
        public function createDocumentFragmentFromDom(DomHelper $domHelper)
        {
            $fragment = $this->createDocumentFragment();
            $fragment->appendXML($domHelper->saveXML());
            return $fragment;
        }

        public function removeAllIds()
        {
            $query = $this->query('//*[@id]');

            /**
             * @var \DOMNode
             */
            foreach ($query as $node) {
                if ($node instanceof \DOMElement) {
                    if ($node->hasAttribute('data-render-keepid')) {
                        $node->removeAttribute('data-render-keepid');
                    } else {
                        $node->removeAttribute('id');
                    }
                }
            }
        }
    }
}
