<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\StatisticNumber;

    class NumberRowRenderer extends AbstractRowRenderer
    {
        /**
         * @var array
         */
        private $classAdditions;

        /**
         * @var mixed
         */
        private $max;

        /**
         * @var mixed
         */
        private $min;

        /**
         * @param string     $label
         * @param array      $data
         * @param bool       $reverseLowestHighest
         *
         * @return \DOMNode
         */
        public function render($label, array $data = [], $reverseLowestHighest = false)
        {
            if ($reverseLowestHighest) {
                $this->classAdditions = [' -lowest', ' -highest'];
            } else {
                $this->classAdditions = [' -highest', ' -lowest'];
            }

            $this->max = max($data);
            $this->min = min($data);
            return parent::render($label, $data);
        }

        /**
         * @param DomHelper $row
         * @param string    $key
         * @param string    $value
         *
         * @return \DomNode
         */
        protected function renderColumn(DomHelper $row, $key, $value)
        {
            $num = (new StatisticNumber((float) $value))->getRounded();

            if ($num === '-0') {
                $num = 0;
            }

            $numberElement = $row->createElement('div', $num);
            $classAddition = '';

            if ($value === $this->max) {
                $classAddition = $this->classAdditions[0];
            }

            if ($value === $this->min) {
                $classAddition = $this->classAdditions[1];
            }

            if ($this->max === $this->min && $value === $this->max) {
                $classAddition = '';
            }

            $numberElement->setAttribute('class', 'value' . $classAddition);

            return $numberElement;
        }
    }
}
