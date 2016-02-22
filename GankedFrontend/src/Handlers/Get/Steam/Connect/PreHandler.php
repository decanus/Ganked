<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Handlers\Get\Steam\Connect
{

    use Ganked\Frontend\Models\SteamConnectModel;
    use Ganked\Library\Logging\LoggerAware;
    use Ganked\Library\Logging\LogProvider;
    use Ganked\Library\ValueObjects\Steam\SteamId;
    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Handlers\PreHandlerInterface;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Models\AbstractModel;

    class PreHandler implements PreHandlerInterface, LoggerAware
    {
        /**
         * @trait
         */
        use LogProvider;

        /**
         * @var \LightOpenID
         */
        private $openID;

        /**
         * @param \LightOpenID $openID
         */
        public function __construct(\LightOpenID $openID)
        {
            $this->openID = $openID;
        }

        /**
         * @param AbstractRequest   $request
         * @param SteamConnectModel $model
         */
        public function execute(AbstractRequest $request, AbstractModel $model)
        {
            if (!$request->hasParameter('openid_claimed_id') || !$this->openID->mode || $this->openID->mode === 'cancel' || !$this->openID->validate()) {
                return;
            }

            try {
                $model->setClaimedId(new SteamId((new Uri($request->getParameter('openid_claimed_id')))->getExplodedPath()[2]));
            } catch (\Exception $e) {
                $this->logCriticalException($e);
            }
        }
    }
}
