<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Models
{
    class ApiPostModel extends ApiModel
    {
        /**
         * @var string
         */
        private $id;

        /**
         * @param string $id
         */
        public function setUserId($id)
        {
            $this->id = $id;
        }

        /**
         * @return string
         */
        public function getUserId()
        {
            return $this->id;
        }
    }
}
