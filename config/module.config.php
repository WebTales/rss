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
            'WebTalesRss\\Frontoffice\\Controller\\Rss' => 'WebTalesRss\\Frontoffice\\Controller\\RssController',
        )
    ),
    'templates' => array(
        'namespaces' => array(
            'Rss' => realpath(__DIR__ . '/../templates')
        ),
    ),
    'router' => array(
        'routes' => array(
            'rss' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/rss/:queryId/:locale[/:type]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'WebTalesRss\Frontoffice\Controller',
                        'constraints' => array(
                            'queryId' => '^[0-9a-fA-F]{24}$',
                            'type' => '^rss|atom$',
                        ),
                        'controller' => 'Rss',
                        'action' => 'index',
                        'type' => 'rss'
                    )
                ),
                'may_terminate' => true
            )
        )
    ),
);