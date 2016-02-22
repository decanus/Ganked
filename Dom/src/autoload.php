<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'dom\\document' => '/Document.php',
                'dom\\documentfragment' => '/DocumentFragment.php',
                'dom\\element' => '/Element.php',
                'dom\\exception' => '/Exception.php',
                'dom\\node' => '/Node.php',
                'dom\\nodelist' => '/NodeList.php',
                'dom\\xpath' => '/XPath.php',
                'dom\\xslt' => '/Xslt.php'
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
