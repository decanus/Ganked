<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Controllers
{

    use Ganked\Frontend\Mappers\LeagueOfLegendsSummonerMapper;
    use Ganked\Frontend\Models\AbstractSummonerModel;
    use Ganked\Frontend\Queries\HasUserFavouritedSummonerQuery;
    use Ganked\Frontend\Renderers\AbstractPageRenderer;
    use Ganked\Library\DataObjects\Accounts\RegisteredAccount;
    use Ganked\Skeleton\Commands\StorePreviousUriCommand;
    use Ganked\Skeleton\Commands\WriteSessionCommand;
    use Ganked\Skeleton\Http\Response\AbstractResponse;
    use Ganked\Skeleton\Models\AbstractPageModel;
    use Ganked\Skeleton\Queries\FetchSessionCookieQuery;
    use Ganked\Skeleton\Queries\IsSessionStartedQuery;

    abstract class AbstractSummonerPageController extends AbstractPageController
    {
        /**
         * @var LeagueOfLegendsSummonerMapper
         */
        private $leagueOfLegendsSummonerMapper;

        /**
         * @var HasUserFavouritedSummonerQuery
         */
        private $hasUserFavouritedSummonerQuery;


        /**
         * @param AbstractResponse               $response
         * @param FetchSessionCookieQuery        $fetchSessionCookieQuery
         * @param AbstractPageRenderer           $renderer
         * @param AbstractPageModel              $model
         * @param WriteSessionCommand            $writeSessionCommand
         * @param StorePreviousUriCommand        $storePreviousUriCommand
         * @param IsSessionStartedQuery          $isSessionStartedQuery
         * @param LeagueOfLegendsSummonerMapper  $leagueOfLegendsSummonerMapper
         * @param HasUserFavouritedSummonerQuery $hasUserFavouritedSummonerQuery
         */
        public function __construct(
            AbstractResponse $response,
            FetchSessionCookieQuery $fetchSessionCookieQuery,
            AbstractPageRenderer $renderer,
            AbstractPageModel $model,
            WriteSessionCommand $writeSessionCommand,
            StorePreviousUriCommand $storePreviousUriCommand,
            IsSessionStartedQuery $isSessionStartedQuery,
            LeagueOfLegendsSummonerMapper $leagueOfLegendsSummonerMapper,
            HasUserFavouritedSummonerQuery $hasUserFavouritedSummonerQuery
        )
        {
            parent::__construct(
                $response,
                $fetchSessionCookieQuery,
                $renderer,
                $model,
                $writeSessionCommand,
                $storePreviousUriCommand,
                $isSessionStartedQuery
            );

            $this->leagueOfLegendsSummonerMapper = $leagueOfLegendsSummonerMapper;
            $this->hasUserFavouritedSummonerQuery = $hasUserFavouritedSummonerQuery;
        }

        protected function doRun()
        {
            /**
             * @var $model AbstractSummonerModel
             */
            $model = $this->getModel();

            $data = $this->getData();
            $model->setSummoner($this->leagueOfLegendsSummonerMapper->map($data['summoner']));

            if (isset($data['summoner']['game']) && $data['summoner']['game'] !== null) {
                $model->setCurrentGame($data['summoner']['game']);
            }

            if (isset($data['summoner']['entry']) && $data['summoner']['entry'] !== null) {
                $model->setEntry($data['summoner']['entry'][0]);
            }

            $this->handleData($data);

            $account = $model->getAccount();
            if ($account instanceof RegisteredAccount) {
                try {
                    $summoner = $model->getSummoner();
                    $model->setHasFavouritedSummoner(
                        $this->hasUserFavouritedSummonerQuery->execute($account->getId(), $summoner->getId(), $summoner->getRegion())
                    );
                } catch (\Exception $e) {
                    $model->setHasFavouritedSummoner(false);
                }
            }
        }

        /**
         * @return array
         */
        abstract protected function getData();

        /**
         * @param array $data
         */
        abstract protected function handleData(array $data = []);

    }
}
