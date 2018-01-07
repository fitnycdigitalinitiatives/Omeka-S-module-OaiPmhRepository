<?php
namespace OaiPmhRepository;

return [
    'api_adapters' => [
        'invokables' => [
            'oaipmh_repository_tokens' => Api\Adapter\OaiPmhRepositoryTokenAdapter::class,
        ],
    ],
    'entity_manager' => [
        'mapping_classes_paths' => [
            dirname(__DIR__) . '/src/Entity',
        ],
        'proxy_paths' => [
            dirname(__DIR__) . '/data/doctrine-proxies',
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ],
    'form_elements' => [
        'factories' => [
            Form\ConfigForm::class => Service\Form\ConfigFormFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\RequestController::class => Service\Controller\RequestControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            OaiPmh\MetadataFormatManager::class => Service\OaiPmh\MetadataFormatManagerFactory::class,
            OaiPmh\OaiSetManager::class => Service\OaiPmh\OaiSetManagerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'site' => [
                'child_routes' => [
                    'oai-pmh' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/oai',
                            'defaults' => [
                                '__NAMESPACE__' => 'OaiPmhRepository\Controller',
                                'controller' => Controller\RequestController::class,
                                'action' => 'index',
                                'oai-repository' => 'by_site',
                            ],
                        ],
                    ],
                ],
            ],
            'oai-pmh' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/oai',
                    'defaults' => [
                        '__NAMESPACE__' => 'OaiPmhRepository\Controller',
                        'controller' => Controller\RequestController::class,
                        'action' => 'index',
                        'oai-repository' => 'global',
                    ],
                ],
            ],
        ],
    ],
    'translator' => [
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => dirname(__DIR__) . '/language',
                'pattern' => '%s.mo',
                'text_domain' => null,
            ],
        ],
    ],
    'oaipmhrepository' => [
        'metadata_formats' => [
            'factories' => [
                'cdwalite' => Service\OaiPmh\Metadata\CdwaLiteFactory::class,
                'mets' => Service\OaiPmh\Metadata\MetsFactory::class,
                'mods' => Service\OaiPmh\Metadata\ModsFactory::class,
                'oai_dc' => Service\OaiPmh\Metadata\OaiDcFactory::class,
            ],
        ],
        'oai_set_formats' => [
            'factories' => [
                'base' => Service\OaiPmh\OaiSet\BaseFactory::class,
            ],
        ],
        'settings' => [
            'oaipmhrepository_name' => '',
            'oaipmhrepository_namespace_id' => '',
            'oaipmhrepository_expose_media' => true,
            'oaipmhrepository_global_repository' => 'item_set',
            'oaipmhrepository_by_site_repository' => 'disabled',
            'oaipmhrepository_oai_set_format' => 'base',
            'oaipmhrepository_list_limit' => 50,
            'oaipmhrepository_token_expiration_time' => 10,
        ],
    ],
];
