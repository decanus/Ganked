<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'ganked\\fetch\\controllers\\datafetchcontrollertest' => '/Controllers/DataFetchControllerTest.php',
                'ganked\\fetch\\factories\\controllerfactorytest' => '/Factories/ControllerFactoryTest.php',
                'ganked\\fetch\\factories\\genericfactorytesthelper' => '/Factories/GenericFactoryTestHelper.php',
                'ganked\\fetch\\factories\\handlerfactorytest' => '/Factories/HandlerFactoryTest.php',
                'ganked\\fetch\\factories\\mapperfactorytest' => '/Factories/MapperFactoryTest.php',
                'ganked\\fetch\\factories\\queryfactorytest' => '/Factories/QueryFactoryTest.php',
                'ganked\\fetch\\factories\\rendererfactorytest' => '/Factories/RendererFactoryTest.php',
                'ganked\\fetch\\factories\\routerfactorytest' => '/Factories/RouterFactoryTest.php',
                'ganked\\fetch\\handlers\\datafetch\\landingpagestreamdatafetchhandlertest' => '/Handlers/DataFetch/LandingPageStreamDataFetchHandlerTest.php',
                'ganked\\fetch\\mappers\\landingpagestreammappertest' => '/Mappers/LandingPageStreamMapperTest.php',
                'ganked\\fetch\\queries\\fetchsteamnewsquerytest' => '/Queries/FetchSteamNewsQueryTest.php',
                'ganked\\fetch\\queries\\fetchtwitchtopstreamsquerytest' => '/Queries/FetchTwitchTopStreamsQueryTest.php',
                'ganked\\fetch\\routers\\datafetchroutertest' => '/Routers/DataFetchRouterTest.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    },
    true,
    false
);
// @codeCoverageIgnoreEnd
