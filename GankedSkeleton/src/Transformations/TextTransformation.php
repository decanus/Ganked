<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Transformations
{
    class TextTransformation extends AbstractTransformation
    {
        /**
         * @param string $id
         * @param string $text
         */
        public function appendTextToId($id, $text)
        {
            $this->queryId($id)->appendChild($this->getTemplate()->createTextNode($text));
        }
    }
}
