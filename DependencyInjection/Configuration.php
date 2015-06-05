<?php

namespace Eps\VhostGeneratorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Eps\VhostGeneratorBundle\DependencyInjection
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $root = $builder->root('vhost_generator');

        $root
            ->children()
                ->arrayNode('apache')
                    ->children()
                        ->scalarNode('vhosts_path')->end()
                        ->scalarNode('output_path')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->arrayNode('vhosts')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('server_name')
                                        ->isRequired()
                                        ->cannotBeEmpty()
                                    ->end()
                                    ->arrayNode('server_aliases')
                                        ->prototype('scalar')->end()
                                    ->end()
                                    ->scalarNode('ip_address')->end()
                                    ->scalarNode('port')->end()
                                    ->scalarNode('document_root')
                                        ->isRequired()
                                        ->cannotBeEmpty()
                                    ->end()
                                    ->arrayNode('directories')
                                        ->prototype('array')
                                            ->children()
                                                ->scalarNode('path')
                                                    ->isRequired()
                                                    ->cannotBeEmpty()
                                                ->end()
                                                ->scalarNode('allow')->end()
                                                ->scalarNode('deny')->end()
                                                ->scalarNode('order')->end()
                                                ->scalarNode('require')->end()
                                                ->arrayNode('allow_override')
                                                    ->prototype('scalar')
                                                    ->end()
                                                ->end()
                                                ->arrayNode('options')
                                                    ->prototype('scalar')
                                                    ->end()
                                                ->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
