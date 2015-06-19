<?php

namespace Eps\VhostGeneratorBundle\Test;

use Eps\VhostGeneratorBundle\DependencyInjection\Compiler\InstallerPass;
use Eps\VhostGeneratorBundle\DependencyInjection\VhostGeneratorExtension;
use Eps\VhostGeneratorBundle\VhostGeneratorBundle;

/**
 * Class VhostGeneratorBundleTest
 * @package Eps\VhostGeneratorBundle\Test
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class VhostGeneratorBundleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldAddCompilerPassesOnBuild()
    {
        $containerBuilder = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->setMethods(['addCompilerPass'])
            ->disableOriginalConstructor()
            ->getMock();

        $containerBuilder->expects($this->once())
            ->method('addCompilerPass')
            ->with(
                $this->callback(
                    function ($compilerPass) {
                        return $compilerPass instanceof InstallerPass;
                    }
                )
            );

        $bundle = new VhostGeneratorBundle();
        $bundle->build($containerBuilder);
    }
}
