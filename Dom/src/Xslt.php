<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Dom
{

    class Xslt extends \XSLTProcessor
    {
        /**
         * @param string $namespace
         * @param array  $parameters
         */
        public function setParameters($namespace, array $parameters = [])
        {
            foreach ($parameters as $name => $value) {
                $this->setParameter($namespace, $name, $value);
            }
        }
    }
}
