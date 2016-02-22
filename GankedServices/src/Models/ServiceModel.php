<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Services\Models
{

    use Ganked\Skeleton\Models\AbstractModel;

    class ServiceModel extends AbstractModel
    {
        /**
         * @var string
         */
        private $method;

        /**
         * @var array
         */
        private $arguments = [];

        /**
         * @param string $method
         */
        public function setMethod($method)
        {
            $this->method = $method;
        }

        /**
         * @param array $arguments
         */
        public function setArguments(array $arguments)
        {
            $this->arguments = $arguments;
        }

        /**
         * @return array
         */
        public function getArguments()
        {
            return $this->arguments;
        }


        /**
         * @return string
         */
        public function getMethod()
        {
            return $this->method;
        }
    }
}