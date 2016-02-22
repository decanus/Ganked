<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Helpers\DomHelper;

    abstract class AbstractRowRenderer
    {
        /**
         * @param string $label
         * @param array  $data
         *
         * @return \DOMNode
         */
        public function render($label, array $data = [])
        {
            $rowDom = new DomHelper('<div class="row"><div class="label">' . $label . '</div></div>');

            foreach ($data as $key => $value) {
                $rowDom->firstChild->appendChild($this->renderColumn($rowDom, $key, $value));
            }

            return $rowDom->documentElement;
        }

        /**
         * @param DomHelper $row
         * @param string    $key
         * @param string    $value
         *
         * @return \DomNode
         */
        abstract protected function renderColumn(DomHelper $row, $key, $value);
    }
}
