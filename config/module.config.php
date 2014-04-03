<?php
return array(
    'localisationfiles' => array(
        'extensions/webtales/rss/locale/languagekey/rss.json'
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
    'templates' => array(
        'namespaces' => array(
            'Rss' => realpath(__DIR__ . '/../templates')
        ),
    ),
);