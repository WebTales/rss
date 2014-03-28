<?php
return array(
    'localisationfiles' => array(
        'module/WebTalesRss/locale/languagekey/rss.json'
    ),
    'blocksDefinition' => array(
        'rss' => array(
            'controller' => 'WebTalesRss\\Blocks\\Controller\\Rss',
            'maxlifeTime' => -1,
            'definitionFile' => realpath(__DIR__ . "/blocks/") . '/rss.json'
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'WebTalesRss\\Blocks\\Controller\\Rss' => 'WebTalesRss\\Blocks\\Controller\\RssController',
        )
    ),
);