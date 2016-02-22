<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Http\Response
{
    class HtmlResponse extends AbstractResponse
    {
        /**
         * @codeCoverageIgnore
         */
        protected function setMimeType()
        {
            $this->setHeader('Content-Type', 'text/html');
        }
    }
}
