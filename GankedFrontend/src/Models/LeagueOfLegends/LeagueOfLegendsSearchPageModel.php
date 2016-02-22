<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Models
{

    class LeagueOfLegendsSearchPageModel extends SearchPageModel
    {
        /**
         * @var array
         */
        private $favourites = [];

        /**
         * @param array $favourites
         */
        public function setFavouriteSummoners(array $favourites = [])
        {
            $this->favourites = $favourites;
        }

        /**
         * @return array
         */
        public function getFavouriteSummoners()
        {
            return $this->favourites;
        }
    }
}
