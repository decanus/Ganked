<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

function handleFile($version, $file)
{

    $template = new \DOMDocument;
    $template->loadXML(file_get_contents($file));

    $xpath = new \DOMXPath($template);

    $css = $xpath->query('//*[@href="//cdn.ganked.net/css/style.css"]');

    if ($css->length === 1) {
        $css->item(0)->setAttribute('href', '//cdn.ganked.net/css/style-' . $version . '.css');
    }

    $js = [
        'ganked',
        'polyfills',
    ];

    foreach ($js as $script) {

        $javascript = $xpath->query('//*[@src="//cdn.ganked.net/js/' . $script . '.js"]');

        if ($javascript->length === 1) {
            $javascript->item(0)->setAttribute('src', '//cdn.ganked.net/js/' . $script . '-' . $version . '.js');
        }
    }

    unlink($file);
    file_put_contents($file, $template->saveXML());

}


$ch = curl_init("https://cdn.ganked.net/version");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);

$version = curl_exec($ch);
curl_close($ch);

foreach ([__DIR__ . '/GankedFrontend/data/templates/template.xhtml', __DIR__ . '/GankedFrontend/html/500.xhtml'] as $file) {
    handleFile($version, $file);
}