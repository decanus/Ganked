<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Models
{
    class JsonErrorPageModel extends AbstractPageModel
    {
        /**
         * @var array
         */
        private $content;

        /**
         * @param array $content
         */
        public function setContent(array $content)
        {
            $this->content = $content;
        }

        /**
         * @return array
         */
        public function getContent()
        {
            return $this->content;
        }
    }
}