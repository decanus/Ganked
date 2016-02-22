<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Handlers\Get\Steam\Connect
{

    use Ganked\Frontend\Models\SteamConnectModel;
    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Handlers\QueryHandlerInterface;
    use Ganked\Skeleton\Http\Redirect\RedirectToUri;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\MovedTemporarily;
    use Ganked\Skeleton\Models\AbstractModel;
    use Ganked\Skeleton\Queries\HasUserBySteamIdQuery;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var HasUserBySteamIdQuery
         */
        private $hasUserBySteamIdQuery;

        /**
         * @param HasUserBySteamIdQuery $hasUserBySteamIdQuery
         */
        public function __construct(HasUserBySteamIdQuery $hasUserBySteamIdQuery)
        {
            $this->hasUserBySteamIdQuery = $hasUserBySteamIdQuery;
        }

        /**
         * @param AbstractRequest   $request
         * @param SteamConnectModel $model
         */
        public function execute(AbstractRequest $request, AbstractModel $model)
        {
            if (!$model->hasClaimedId()) {
                return;
            }

            if (!$this->hasUserBySteamIdQuery->execute($model->getClaimedId())) {
                $model->setRedirect(new RedirectToUri(new Uri('https://post.ganked.net/action/connect/steam'), new MovedTemporarily));
                return;
            }

            $model->claimedIdHasAlreadyBeenUsed();
        }
    }
}
