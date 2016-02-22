<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Models
{

    use Ganked\Skeleton\Models\AbstractPageModel;

    class SearchPageModel extends AbstractPageModel
    {
        /**
         * @var array
         */
        private $searchResult;

        /**
         * @param array $searchResult
         */
        public function setSearchResult(array $searchResult)
        {
            $this->searchResult = $searchResult;
        }

        /**
         * @return array
         */
        public function getSearchResult()
        {
            return $this->searchResult;
        }
    }
}
