<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    class Post 
    {
        /**
         * @var string
         */
        private $post;


        /**
         * @param string $post
         *
         * @throws \InvalidArgumentException
         */
        public function __construct($post)
        {
            if (strlen($post) > 300) {
                throw new \InvalidArgumentException('Post exceeds 300 characters');
            }

            $this->post = strip_tags($post);
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return $this->post;
        }
    }
}
