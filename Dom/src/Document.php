<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Dom
{

    /**
     * @property Document $ownerDocument
     */
    class Document extends \DOMDocument
    {
        /**
         * @var XPath
         */
        private $xpath;

        /**
         * @param string $version
         * @param string $encoding
         */
        public function __construct($version = '1.0', $encoding = 'utf-8')
        {
            parent::__construct($version, $encoding);
            $this->registerClasses();
        }

        /**
         * @param string $expression
         * @param Node   $contextNode
         *
         * @return \DomNodeList
         */
        public function query($expression, Node $contextNode = null)
        {
            return $this->getXPath()->query($expression, $contextNode);
        }

        /**
         * @param string $expression
         * @param Node   $contextNode
         *
         * @return Node
         */
        public function queryOne($expression, Node $contextNode = null)
        {
            return $this->getXPath()->queryOne($expression, $contextNode);
        }

        /**
         * @return XPath
         */
        public function getXPath()
        {
            if ($this->xpath === null) {
                $this->xpath = new XPath($this);
            }

            return $this->xpath;
        }

        /**
         * @param string $prefix
         * @param string $namespaceUri
         */
        public function registerNamespace($prefix, $namespaceUri)
        {
            $this->getXPath()->registerNamespace($prefix, $namespaceUri);
        }

        private function registerClasses()
        {
            $this->registerNodeClass('DomDocument', \Dom\Document::class);
            $this->registerNodeClass('DOMNode', \Dom\Node::class);
            $this->registerNodeClass('DOMElement', \Dom\Element::class);
            $this->registerNodeClass('DOMDocumentFragment', \Dom\DocumentFragment::class);
        }
    }
}
