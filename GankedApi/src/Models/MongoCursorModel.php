<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\API\Models
{

    class MongoCursorModel extends ApiModel
    {
        /**
         * @var \MongoCursor
         */
        private $cursor;

        /**
         * @param \MongoCursor $cursor
         */
        public function setCursor(\MongoCursor $cursor)
        {
            $this->cursor = $cursor;
        }

        /**
         * @return \MongoCursor
         */
        public function getCursor()
        {
            return $this->cursor;
        }
    }
}
