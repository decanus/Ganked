<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */


// @codeCoverageIgnoreStart
namespace Ganked\Skeleton\ErrorHandlers
{

    use Ganked\Library\Logging\LoggerAware;
    use Ganked\Library\Logging\LogProvider;
    use Ganked\Library\ValueObjects\Uri;

    class ProductionErrorHandler extends AbstractErrorHandler implements LoggerAware
    {

        /**
         * @provider
         */
        use LogProvider;

        /**
         * @param \Exception $exception
         */
        public function handleException(\Exception $exception)
        {
            $this->logCriticalException($exception);

            $errorUri = new Uri($_SERVER['HTTP_HOST'] . '/500');
            header('Location:' . $errorUri);
            die();
        }
    }
}
// @codeCoverageIgnoreEnd
