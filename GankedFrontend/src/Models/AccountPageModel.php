<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Models
{

    use Ganked\Skeleton\Models\AbstractPageModel;

    class AccountPageModel extends AbstractPageModel
    {
        /**
         * @var array
         */
        private $accountData;

        /**
         * @param array $data
         */
        public function setAccountData(array $data)
        {
            $this->accountData = $data;
        }

        /**
         * @return array
         */
        public function getAccountData()
        {
            return $this->accountData;
        }
    }
}
