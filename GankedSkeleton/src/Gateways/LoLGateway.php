<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Gateways
{

    use Ganked\Skeleton\Backends\Wrappers\CurlResponse;

    /**
     * @method CurlResponse getSummonersByName(string $username)
     * @method CurlResponse getRecentGamesForSummoner(string $region, int $id)
     * @method CurlResponse getSummonerForRegionByName(string $region, string $name)
     * @method CurlResponse getFreeChampions()
     * @method CurlResponse getMatchlistsForSummonersInRegionByUsername(array $summoners, string $region)
     * @method CurlResponse getSummonersForRegion(string $region, array $summoners)
     * @method CurlResponse getCurrentGameForSummonerInRegionWithData(string $summonerName, string $region)
     * @method CurlResponse getRankedStatsForSummoner(string $username, string $region)
     * @method CurlResponse getLeagueEntryForSummoner(string $username, string $region)
     * @method CurlResponse getMatchlistForSummoner(string $username, string $region)
     * @method CurlResponse getSummonerComparisonStats(array $summoners)
     */
    class LoLGateway extends AbstractGateway
    {
    }
}
