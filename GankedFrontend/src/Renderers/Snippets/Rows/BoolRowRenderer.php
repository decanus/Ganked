<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Helpers\DomHelper;

    class BoolRowRenderer extends AbstractRowRenderer
    {

        /**
         * @param DomHelper $row
         * @param string    $key
         * @param string    $value
         *
         * @return \DomNode
         */
        protected function renderColumn(DomHelper $row, $key, $value)
        {
            $boolElement = $row->createElement('div');

            if ($value) {
                $content = $row->createElement('span');
                $content->setAttribute('class', 'octicon octicon-check _green');
            } else {
                $content = $row->createTextNode('--');
            }

            $boolElement->appendChild($content);
            $boolElement->setAttribute('class', 'value');

            return $boolElement;
        }
    }
}
