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
    class Node extends \DOMNode
    {
        /**
         * @param string $name
         * @param string $value
         *
         * @return Node
         */
        public function appendElement($name, $value = null)
        {
            return $this->appendChild($this->ownerDocument->createElement($name, $value));
        }

        /**
         * @param string $xml
         *
         * @return Node
         */
        public function appendXML($xml)
        {
            $fragment = $this->ownerDocument->createDocumentFragment();
            $fragment->appendXML($xml);
            return $this->appendChild($fragment);
        }

        /**
         * @param string $expression
         *
         * @return \DomNodeList
         */
        public function query($expression)
        {
            return $this->ownerDocument->query($expression, $this);
        }
    }
}
