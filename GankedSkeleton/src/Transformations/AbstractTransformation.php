<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Transformations
{

    use Ganked\Library\Helpers\DomHelper;

    abstract class AbstractTransformation
    {
        /**
         * @var DomHelper
         */
        private $template;

        /**
         * @param DomHelper $template
         */
        public function setTemplate(DomHelper $template)
        {
            $this->template = $template;
        }

        /**
         * @return DomHelper
         */
        protected function getTemplate()
        {
            return $this->template;
        }

        /**
         * @param string $id
         *
         * @return \DOMNode
         * @throws \OutOfBoundsException
         */
        protected function queryId($id)
        {
            $node = $this->getTemplate()->getElementById($id);

            if ($node === null) {
                throw new \OutOfBoundsException('Element with id ' . $id . ' not found');
            }

            return $node;
        }

        /**
         * @param DomHelper $snippet
         *
         * @return \DOMNode
         *
         */
        protected function importNode(DomHelper $snippet)
        {
            return $this->getTemplate()->importNode($snippet->documentElement, true);
        }
    }
}
