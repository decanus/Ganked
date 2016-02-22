<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers
{

    use Ganked\API\Exceptions\ApiException;
    use Ganked\API\Readers\TokenReader;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\Unauthorized;

    class PreHandler
    {
        /**
         * @var TokenReader
         */
        private $tokenReader;

        /**
         * @param TokenReader $tokenReader
         */
        public function __construct(TokenReader $tokenReader)
        {
            $this->tokenReader = $tokenReader;
        }

        /**
         * @param AbstractRequest $request
         *
         * @throws \Exception
         * @throws \RuntimeException
         */
        public function execute(AbstractRequest $request)
        {
            if (!$request->hasParameter('api_key')) {
                throw new ApiException('API key is required for this request', 0, null, new Unauthorized);
            }

            if (!$this->tokenReader->hasToken($request->getParameter('api_key'))) {
                throw new ApiException('Invalid API key', 0, null, new Unauthorized);
            }
        }
    }
}
