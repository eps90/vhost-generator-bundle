<?php

namespace DependencyInjection;

use Eps\VhostGeneratorBundle\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;

/**
 * Class ConfigurationTest
 * @package DependencyInjection
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    use ConfigurationTestCaseTrait;

    public function validConfigProvider()
    {
        return [
            'happy_path' => [
                'config' => [
                    [
                        'apache' => [
                            'vhosts_path' => '/etc/apache2/sites-available',
                            'output_path' => 'prod.conf',
                            'vhosts' => [
                                [
                                    'server_name' => 'www.example.com',
                                    'server_aliases' => [
                                        'example.com'
                                    ],
                                    'document_root' => '/srv/www/data',
                                    'ip_address' => '127.0.0.1',
                                    'port' => '8080',
                                    'directories' => [
                                        [
                                            'path' => '/srv/www/data',
                                            'allow_override' => [
                                                'All'
                                            ],
                                            'deny' => 'all',
                                            'allow' => 'all',
                                            'order' => 'allow deny',
                                            'require' => 'all granted',
                                            'options' => [
                                                'Indexes'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'missing_optional_values' => [
                'config' => [
                    [
                        'apache' => [
                            'output_path' => 'prod.conf',
                            'vhosts' => [
                                [
                                    'server_name' => 'www.example.com',
                                    'document_root' => '/srv/www/data'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'empty_config' => [
                'config' => []
            ]
        ];
    }

    /**
     * @test
     * @dataProvider validConfigProvider
     */
    public function itShouldParseConfigProperly($config)
    {
        $this->assertConfigurationIsValid($config);
    }

    public function invalidConfigProvider()
    {
        return [
            'missing_output_path' => [
                'config' => [
                    [
                        'apache' => [
                            'vhosts_path' => '/etc/apache2/sites-available',
                            'vhosts' => [
                                [
                                    'server_name' => 'www.example.com',
                                    'server_aliases' => [
                                        'example.com'
                                    ],
                                    'document_root' => '/srv/www/data',
                                    'ip_address' => '127.0.0.1',
                                    'port' => '8080',
                                    'directories' => [
                                        [
                                            'path' => '/srv/www/data',
                                            'allow_override' => [
                                                'All'
                                            ],
                                            'allow' => 'all',
                                            'require' => 'all granted',
                                            'options' => [
                                                'Indexes'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'missing_server_name_in_vhost' => [
                'config' => [
                    [
                        'apache' => [
                            'vhosts_path' => '/etc/apache2/sites-available',
                            'output_path' => 'prod.conf',
                            'vhosts' => [
                                [
                                    'server_aliases' => [
                                        'example.com'
                                    ],
                                    'document_root' => '/srv/www/data',
                                    'ip_address' => '127.0.0.1',
                                    'port' => '8080',
                                    'directories' => [
                                        [
                                            'path' => '/srv/www/data',
                                            'allow_override' => [
                                                'All'
                                            ],
                                            'allow' => 'all',
                                            'require' => 'all granted',
                                            'options' => [
                                                'Indexes'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'missing_document_root_in_vhost' => [
                'config' => [
                    [
                        'apache' => [
                            'vhosts_path' => '/etc/apache2/sites-available',
                            'output_path' => 'prod.conf',
                            'vhosts' => [
                                [
                                    'server_name' => 'www.example.com',
                                    'server_aliases' => [
                                        'example.com'
                                    ],
                                    'ip_address' => '127.0.0.1',
                                    'port' => '8080',
                                    'directories' => [
                                        [
                                            'path' => '/srv/www/data',
                                            'allow_override' => [
                                                'All'
                                            ],
                                            'allow' => 'all',
                                            'require' => 'all granted',
                                            'options' => [
                                                'Indexes'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'missing_path_in_directory' => [
                'config' => [
                    [
                        'apache' => [
                            'vhosts_path' => '/etc/apache2/sites-available',
                            'output_path' => 'prod.conf',
                            'vhosts' => [
                                [
                                    'server_name' => 'www.example.com',
                                    'server_aliases' => [
                                        'example.com'
                                    ],
                                    'document_root' => '/srv/www/data',
                                    'ip_address' => '127.0.0.1',
                                    'port' => '8080',
                                    'directories' => [
                                        [
                                            'allow_override' => [
                                                'All'
                                            ],
                                            'allow' => 'all',
                                            'require' => 'all granted',
                                            'options' => [
                                                'Indexes'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider invalidConfigProvider
     */
    public function itShouldDefineRequiredValues($config)
    {
        $this->assertConfigurationIsInvalid($config);
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return new Configuration();
    }
}
