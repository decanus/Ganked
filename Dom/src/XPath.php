<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Dom
{

    class XPath extends \DOMXPath
    {
        /**
         * @param string $expression
         * @param Node   $contextNode
         *
         * @return Node
         */
        public function queryOne($expression, Node $contextNode = null)
        {
            return $this->query($expression, $contextNode)->item(0);
        }

        /**
         * @param string $expression
         * @param Node   $contextNode
         *
         * @return Node
         */
        public function hasByQuery($expression, Node $contextNode = null)
        {
            return $this->queryOne($expression, $contextNode) !== null;
        }
    }
}
