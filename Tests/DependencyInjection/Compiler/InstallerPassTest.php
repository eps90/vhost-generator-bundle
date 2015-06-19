<?php

namespace Eps\VhostGeneratorBundle\Test\DependencyInjection\Compiler;

use Eps\VhostGeneratorBundle\DependencyInjection\Compiler\InstallerPass;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class InstallerPassTest
 * @package Eps\VhostGeneratorBundle\Test\DependencyInjection\Compiler
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class InstallerPassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldAttachInstallersToFactories()
    {
        $containerBuilder = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->disableOriginalConstructor()
            ->setMethods(['findTaggedServiceIds', 'getDefinition'])
            ->getMock();

        $installerFactories = [
            'factory_a' => [
                [
                    'name' => 'vhost_installer_factory',
                    'server' => 'apache'
                ]
            ]
        ];

        $containerBuilder->expects($this->at(0))
            ->method('findTaggedServiceIds')
            ->with('vhost_installer_factory')
            ->willReturn($installerFactories);

        $installers = [
            'installer_a' => [
                [
                    'name' => 'vhost_installer.apache',
                    'os' => 'linux'
                ]
            ]
        ];

        $containerBuilder->expects($this->at(2))
            ->method('findTaggedServiceIds')
            ->with('vhost_installer.apache')
            ->willReturn($installers);

        $factoryADefinition = $this->getMockBuilder('Symfony\Component\DependencyInjection\Definition')
            ->disableOriginalConstructor()
            ->getMock();

        $containerBuilder->expects($this->at(1))
            ->method('getDefinition')
            ->with('factory_a')
            ->willReturn($factoryADefinition);

        $factoryADefinition->expects($this->once())
            ->method('addMethodCall')
            ->with(
                'addInstaller',
                $this->callback(
                    function (array $arguments) {
                        return $arguments[0] == 'linux'
                            && $arguments[1] instanceof Reference
                            && ((string) $arguments[1]) == 'installer_a';
                    }
                )
            );

        $installerPass = new InstallerPass();
        $installerPass->process($containerBuilder);
    }

    /**
     * @test
     */
    public function itShouldNotAttachInstallersIfThereIsNoFactory()
    {
        $containerBuilder = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->disableOriginalConstructor()
            ->setMethods(['findTaggedServiceIds', 'getDefinition'])
            ->getMock();

        $containerBuilder->expects($this->at(0))
            ->method('findTaggedServiceIds')
            ->with('vhost_installer_factory')
            ->willReturn(null);

        $containerBuilder->expects($this->never())
            ->method('getDefinition');

        $installerPass = new InstallerPass();
        $installerPass->process($containerBuilder);
    }

    /**
     * @test
     */
    public function itShouldAttachInstallersIfThereAreNoOnes()
    {
        $containerBuilder = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->disableOriginalConstructor()
            ->setMethods(['findTaggedServiceIds', 'getDefinition'])
            ->getMock();

        $installerFactories = [
            'factory_a' => [
                [
                    'name' => 'vhost_installer_factory',
                    'server' => 'apache'
                ]
            ]
        ];

        $containerBuilder->expects($this->at(0))
            ->method('findTaggedServiceIds')
            ->with('vhost_installer_factory')
            ->willReturn($installerFactories);

        $containerBuilder->expects($this->at(2))
            ->method('findTaggedServiceIds')
            ->with('vhost_installer.apache')
            ->willReturn(null);

        $factoryADefinition = $this->getMockBuilder('Symfony\Component\DependencyInjection\Definition')
            ->disableOriginalConstructor()
            ->getMock();

        $containerBuilder->expects($this->at(1))
            ->method('getDefinition')
            ->with('factory_a')
            ->willReturn($factoryADefinition);

        $factoryADefinition->expects($this->never())
            ->method('addMethodCall');

        $installerPass = new InstallerPass();
        $installerPass->process($containerBuilder);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function itShouldThrowIfTagsHasNoProperAttribute()
    {
        $containerBuilder = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->disableOriginalConstructor()
            ->setMethods(['findTaggedServiceIds', 'getDefinition'])
            ->getMock();

        $installerFactories = [
            'factory_a' => [
                [
                    'name' => 'vhost_installer_factory'
                ]
            ]
        ];

        $containerBuilder->expects($this->at(0))
            ->method('findTaggedServiceIds')
            ->with('vhost_installer_factory')
            ->willReturn($installerFactories);

        $factoryADefinition = $this->getMockBuilder('Symfony\Component\DependencyInjection\Definition')
            ->disableOriginalConstructor()
            ->getMock();

        $containerBuilder->expects($this->at(1))
            ->method('getDefinition')
            ->with('factory_a')
            ->willReturn($factoryADefinition);

        $installerPass = new InstallerPass();
        $installerPass->process($containerBuilder);
    }
}
