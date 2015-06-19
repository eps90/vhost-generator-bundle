<?php

namespace Eps\VhostGeneratorBundle;

use Eps\VhostGeneratorBundle\DependencyInjection\Compiler\InstallerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class VhostGeneratorBundle
 * @package Eps\VhostGeneratorBundle
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class VhostGeneratorBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new InstallerPass());
    }
}
