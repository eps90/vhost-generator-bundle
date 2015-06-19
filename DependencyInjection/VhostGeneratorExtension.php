<?php

namespace Eps\VhostGeneratorBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class VhostGeneratorExtension
 * @package Eps\VhostGeneratorBundle\DependencyInjection
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class VhostGeneratorExtension extends Extension
{

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('apache_generator.yml');
        $loader->load('commands.yml');
        $loader->load('installers.yml');
        $loader->load('utils.yml');

        if (isset($config['apache']['vhosts_path'])) {
            $container->setParameter('eps.vhost_generator.apache.vhosts_path', $config['apache']['vhosts_path']);
        }

        if (isset($config['apache']['output_file'])) {
            $container->setParameter('eps.vhost_generator.apache.output_file', $config['apache']['output_file']);
        }

        if (isset($config['apache']['vhosts']) && !empty($config['apache']['vhosts'])) {
            $container->setParameter('eps.vhost_generator.apache.vhosts', $config['apache']['vhosts']);
        }
    }
}
