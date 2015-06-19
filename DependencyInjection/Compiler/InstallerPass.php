<?php

namespace Eps\VhostGeneratorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class InstallerPass
 * @package Eps\VhostGeneratorBundle\DependencyInjection\Compiler
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class InstallerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $installerFactories = $container->findTaggedServiceIds('vhost_installer_factory');
        if (!$installerFactories) {
            return;
        }

        foreach ($installerFactories as $serviceId => $serviceTags) {
            $definition = $container->getDefinition($serviceId);
            $serverName = $this->getTagAttribute($serviceTags, 'server');

            $installers = $container->findTaggedServiceIds('vhost_installer.' . $serverName);
            if (!$installers) {
                continue;
            }

            foreach ($installers as $installerId => $installerTags) {
                $operatingSystem = $this->getTagAttribute($installerTags, 'os');

                $definition->addMethodCall(
                    'addInstaller',
                    [$operatingSystem, new Reference($installerId)]
                );
            }
        }
    }

    /**
     * @param array $serviceTags
     * @param $attribute
     * @return null
     */
    private function getTagAttribute(array $serviceTags, $attribute)
    {
        $attributeValue = null;
        foreach ($serviceTags as $attributes) {
            if (isset($attributes[$attribute])) {
                $attributeValue = $attributes[$attribute];
                break;
            }
        }

        if ($attributeValue === null) {
            throw new \RuntimeException("Tag attribute '$attribute' not found!");
        }

        return $attributeValue;
    }
}
