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
                    'output_file' => 'prod.conf',
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
        ];

        $extension->load($config, $containerBuilder);
        $this->assertEquals(
            '/etc/apache2/sites-available',
            $containerBuilder->getParameter(
                'eps.vhost_generator.apache.vhosts_path'
            )
        );
        $this->assertEquals(
            'prod.conf',
            $containerBuilder->getParameter(
                'eps.vhost_generator.apache.output_file'
            )
        );
        $this->assertEquals(
            [
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
            ],
            $containerBuilder->getParameter('eps.vhost_generator.apache.vhosts')
        );
    }

    /**
     * @test
     */
    public function itShouldHaveConfiguredNodeFactoryServices()
    {
        $containerBuilder = new ContainerBuilder();
        $config = [];

        $extension = new VhostGeneratorExtension();
        $extension->load($config, $containerBuilder);

        $this->assertTrue($containerBuilder->has('eps.vhost_generator.apache.vhost_node_factory'));
        $this->assertTrue($containerBuilder->has('eps.vhost_generator.apache.directory_node_factory'));
    }

    /**
     * @test
     */
    public function itShouldHaveConfiguredVHostGeneratorsServices()
    {
        $containerBuilder = new ContainerBuilder();
        $config = [];

        $extension = new VhostGeneratorExtension();
        $extension->load($config, $containerBuilder);

        $this->assertTrue($containerBuilder->has('eps.vhost_generator.apache.generator'));
    }

    /**
     * @test
     */
    public function itShouldHaveConfiguredFormatterServices()
    {
        $containerBuilder = new ContainerBuilder();
        $config = [];

        $extension = new VhostGeneratorExtension();
        $extension->load($config, $containerBuilder);

        $this->assertTrue($containerBuilder->has('eps.vhost_generator.apache.formatter'));
    }

    /**
     * @test
     */
    public function itShouldHaveConfiguredCommandsAsServices()
    {
        $container = new ContainerBuilder();
        $config = [];

        $extension = new VhostGeneratorExtension();
        $extension->load($config, $container);

        $this->assertTrue($container->has('eps.vhost_generator.apache.command.generate'));
    }

    /**
     * @test
     */
    public function itShouldHaveConfiguredUtilsServices()
    {
        $container = new ContainerBuilder();
        $config = [];

        $extension = new VhostGeneratorExtension();
        $extension->load($config, $container);

        $this->assertTrue($container->has('eps.vhost_generator.process_factory'));
        $this->assertTrue($container->has('eps.vhost_generator.operating_system'));
        $this->assertTrue($container->has('eps.vhost_generator.os_detector'));
    }

    /**
     * @test
     */
    public function itShouldHaveConfiguredInstallers()
    {
        $container = new ContainerBuilder();
        $config = [];

        $extension = new VhostGeneratorExtension();
        $extension->load($config, $container);

        $this->assertTrue($container->has('eps.vhost_generator.installer.apache.factory'));
        $this->assertTrue($container->has('eps.vhost_generator.installer.apache'));
        $this->assertTrue($container->has('eps.vhost_generator.installer.apache.linux'));
    }
}
