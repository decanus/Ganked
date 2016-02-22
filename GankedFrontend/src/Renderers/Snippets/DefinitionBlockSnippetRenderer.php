<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
namespace Ganked\Frontend\Renderers
{
    use Ganked\Library\Helpers\DomHelper;

    class DefinitionBlockSnippetRenderer
    {
        /**
         * @param string $definition
         * @param mixed $value
         * @return DomHelper
         */
        public function render($definition, $value)
        {
            $dom = new DomHelper('<div />');

            $block = $dom->firstChild;
            $block->setAttribute('class', 'definition-block');

            $definition = $block->appendChild($dom->createElement('span', $definition));
            $definition->setAttribute('class', 'definition');

            $value = $block->appendChild($dom->createElement('span', $value));
            $value->setAttribute('class', 'value');

            return $dom;
        }
    }
}
