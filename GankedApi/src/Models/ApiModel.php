<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Models
{

    use Ganked\API\Exceptions\ApiException;
    use Ganked\Skeleton\Models\AbstractModel;

    class ApiModel extends AbstractModel
    {
        /**
         * @var array
         */
        private $data = [];

        /**
         * @var \Exception
         */
        private $exception;

        /**
         * @var string
         */
        private $type;

        /**
         * @param string $type
         */
        public function setObjectType($type)
        {
            $this->type = $type;
        }

        /**
         * @return string
         */
        public function getObjectType()
        {
            return $this->type;
        }

        /**
         * @param array $data
         */
        public function setData(array $data)
        {
            $this->data = $data;
        }

        /**
         * @return array
         */
        public function getData()
        {
            return $this->data;
        }

        /**
         * @param ApiException $exception
         */
        public function setException(ApiException $exception)
        {
            $this->exception = $exception;
        }

        /**
         * @return ApiException
         */
        public function getException()
        {
            return $this->exception;
        }

        /**
         * @return bool
         */
        public function hasException()
        {
            return isset($this->exception);
        }
    }
}
