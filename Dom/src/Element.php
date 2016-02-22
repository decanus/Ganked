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
    class Element extends \DOMElement
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
         * @param string $query
         *
         * @return \DomNodeList
         */
        public function query($query)
        {
            return $this->ownerDocument->query($query, $this);
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
    }
}
