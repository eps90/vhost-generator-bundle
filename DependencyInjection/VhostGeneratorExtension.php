<?php

namespace Eps\VhostGeneratorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class VhostGeneratorExtension
 * @package Eps\VhostGeneratorBundle\DependencyInjection
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class VhostGeneratorExtension extends Extension
{

    /**
     * Loads a specific configuration.
     *
     * @param array $configs An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (isset($config['apache']['vhosts_path'])) {
            $container->setParameter('vhost_generator.apache.vhosts_path', $config['apache']['vhosts_path']);
        }

        if (isset($config['apache']['output_path'])) {
            $container->setParameter('vhost_generator.apache.output_path', $config['apache']['output_path']);
        }

        if (isset($config['apache']['vhosts']) && !empty($config['apache']['vhosts'])) {
            $container->setParameter('vhost_generator.apache.vhosts', $config['apache']['vhosts']);
        }
    }
}
