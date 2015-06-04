<?php

namespace Eps\VhostGeneratorBundle\Test\DependencyInjection;

use Eps\VhostGeneratorBundle\DependencyInjection\VhostGeneratorExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class VhostGeneratorExtensionTest
 * @package Eps\VhostGeneratorBundle\Test\DependencyInjection
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class VhostGeneratorExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldSetCorrectPropertiesInContainer()
    {
        $extension = new VhostGeneratorExtension();
        $containerBuilder = new ContainerBuilder();
        $config = [
            [
                'apache' => [
                    'vhosts_path' => '/etc/apache2/sites-available',
                    'output_path' => 'prod.conf',
                    'vhosts' => [
                        [
                            'server_name' => 'www.example.com',
                            'server_alias' => 'example.com',
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
        ];

        $extension->load($config, $containerBuilder);
        $this->assertEquals('/etc/apache2/sites-available', $containerBuilder->getParameter('vhost_generator.apache.vhosts_path'));
        $this->assertEquals('prod.conf', $containerBuilder->getParameter('vhost_generator.apache.output_path'));
        $this->assertEquals(
            [
                [
                    'server_name' => 'www.example.com',
                    'server_alias' => 'example.com',
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
            ],
            $containerBuilder->getParameter('vhost_generator.apache.vhosts')
        );
    }
}
