<?php
/**
* Copyright (c) Ganked 2015
* All rights reserved.
*/
namespace Ganked\Skeleton\Gateways
{

    use Ganked\Skeleton\Backends\Wrappers\CurlResponse;

    /**
     * @method CurlResponse isVerifiedForBeta($email)
     * @method CurlResponse setUserVerified($email)
     * @method CurlResponse getUserHash($email)
     * @method CurlResponse hasBetaRequest($email)
     * @method CurlResponse updateUserPassword($password, $email)
     * @method CurlResponse setUserHash($email, $hash)
     */
    class AccountGateway extends AbstractGateway
    {

    }
}