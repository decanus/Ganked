<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Helpers\DomHelper;

    class BarGraphRenderer
    {

        /**
         * @param string $value
         * @param string $outOf
         * @param string $label
         * @param string $barColour
         *
         * @return \DOMElement
         */
        public function render($value, $outOf, $label = '', $barColour = '')
        {
            $graph = new DomHelper('<div class="bar-graph" />');

            $bar = $graph->createElement('div');

            if ($barColour === 'purple') {
                $barColour = '-purple';
            }

            $bar->setAttribute('class', 'bar ' . $barColour);
            try {
                $width = ($value / $outOf) * 100;
            } catch (\Exception $e) {
                $width = 0;
            }

            $bar->setAttribute('style', 'width: ' . $width . '%;');
            if ($label !== '') {
                $labelElement = $graph->createElement('div', $label);
                $labelElement->setAttribute('class', 'label');
                $bar->appendChild($labelElement);
            }

            $graph->firstChild->appendChild($bar);

            return $graph->firstChild;
        }
    }
}
