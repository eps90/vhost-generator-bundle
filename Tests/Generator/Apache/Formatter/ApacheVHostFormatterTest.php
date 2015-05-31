<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Apache\Formatter;

use Eps\VhostGeneratorBundle\Generator\Apache\Formatter\ApacheVHostFormatter;
use Eps\VhostGeneratorBundle\Generator\Apache\Node\ApacheVHostNode;
use Eps\VhostGeneratorBundle\Generator\Apache\Node\DirectoryNode;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\AllowOverrideProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\AllowProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\RequireProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\DocumentRootProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerAliasProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerNameProperty;

/**
 * Class ApacheVHostFormatterTest
 * @package Eps\VhostGeneratorBundle\Tests\Generator\Apache\Formatter
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ApacheVHostFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldRenderConfiguration()
    {
        $expected = <<<CONFIG
<VirtualHost *:80>
    ServerName www.example.com
    ServerAlias example.com
    DocumentRoot /srv/www/someData
</VirtualHost>

CONFIG;

        $formatter = new ApacheVHostFormatter();

        $vhostName = 'VirtualHost';
        $vhostNode = $this->getMock('Eps\VhostGeneratorBundle\Generator\Node\NodeInterface');
        $vhostNode->expects($this->once())
            ->method('getName')
            ->willReturn($vhostName);

        $serverName = $this->getMock('Eps\VhostGeneratorBundle\Generator\Property\PropertyInterface');
        $serverName->expects($this->once())
            ->method('getName')
            ->willReturn('ServerName');
        $serverName->expects($this->once())
            ->method('getValue')
            ->willReturn('www.example.com');

        $serverAlias = $this->getMock('Eps\VhostGeneratorBundle\Generator\Property\PropertyInterface');
        $serverAlias->expects($this->once())
            ->method('getName')
            ->willReturn('ServerAlias');
        $serverAlias->expects($this->once())
            ->method('getValue')
            ->willReturn('example.com');

        $documentRoot = $this->getMock('Eps\VhostGeneratorBundle\Generator\Property\PropertyInterface');
        $documentRoot->expects($this->once())
            ->method('getName')
            ->willReturn('DocumentRoot');
        $documentRoot->expects($this->once())
            ->method('getValue')
            ->willReturn('/srv/www/someData');

        $vhostNode->expects($this->once())
            ->method('getAttributes')
            ->willReturn(
                [
                    ApacheVHostNode::ADDRESS => '*:80'
                ]
            );
        $vhostNode->expects($this->once())
            ->method('getProperties')
            ->willReturn(
                [
                    ServerNameProperty::NAME => $serverName,
                    ServerAliasProperty::NAME => $serverAlias,
                    DocumentRootProperty::NAME => $documentRoot
                ]
            );
        $vhostNode->expects($this->once())
            ->method('getNodes')
            ->willReturn([]);

        $actual = $formatter->createConfig([$vhostNode]);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function itShouldRenderConfigurationWithNestedNodes()
    {
        $expected = <<<CONFIG
<VirtualHost *:80>
    ServerName www.example.com
    ServerAlias example.com
    DocumentRoot /srv/www/someData

    <Directory /srv/www/someData>
        AllowOverride All
        Allow from all
        Require all granted
    </Directory>
</VirtualHost>

CONFIG;

        $formatter = new ApacheVHostFormatter();

        $vhostName = 'VirtualHost';
        $vhostNode = $this->getMock('Eps\VhostGeneratorBundle\Generator\Node\NodeInterface');
        $vhostNode->expects($this->once())
            ->method('getName')
            ->willReturn($vhostName);

        $serverName = $this->getMock('Eps\VhostGeneratorBundle\Generator\Property\PropertyInterface');
        $serverName->expects($this->once())
            ->method('getName')
            ->willReturn('ServerName');
        $serverName->expects($this->once())
            ->method('getValue')
            ->willReturn('www.example.com');

        $serverAlias = $this->getMock('Eps\VhostGeneratorBundle\Generator\Property\PropertyInterface');
        $serverAlias->expects($this->once())
            ->method('getName')
            ->willReturn('ServerAlias');
        $serverAlias->expects($this->once())
            ->method('getValue')
            ->willReturn('example.com');

        $documentRoot = $this->getMock('Eps\VhostGeneratorBundle\Generator\Property\PropertyInterface');
        $documentRoot->expects($this->once())
            ->method('getName')
            ->willReturn('DocumentRoot');
        $documentRoot->expects($this->once())
            ->method('getValue')
            ->willReturn('/srv/www/someData');

        $vhostNode->expects($this->once())
            ->method('getAttributes')
            ->willReturn(
                [
                    ApacheVHostNode::ADDRESS => '*:80'
                ]
            );
        $vhostNode->expects($this->once())
            ->method('getProperties')
            ->willReturn(
                [
                    ServerNameProperty::NAME => $serverName,
                    ServerAliasProperty::NAME => $serverAlias,
                    DocumentRootProperty::NAME => $documentRoot
                ]
            );

        $allowOverrideProperty = $this->getMock('Eps\VhostGeneratorBundle\Generator\Property\PropertyInterface');
        $allowOverrideProperty->expects($this->once())
            ->method('getName')
            ->willReturn('AllowOverride');
        $allowOverrideProperty->expects($this->once())
            ->method('getValue')
            ->willReturn(AllowOverrideProperty::ALL);

        $allowProperty = $this->getMock('Eps\VhostGeneratorBundle\Generator\Property\PropertyInterface');
        $allowProperty->expects($this->once())
            ->method('getName')
            ->willReturn('Allow');
        $allowProperty->expects($this->once())
            ->method('getValue')
            ->willReturn('from all');

        $requireProperty = $this->getMock('Eps\VhostGeneratorBundle\Generator\Property\PropertyInterface');
        $requireProperty->expects($this->once())
            ->method('getName')
            ->willReturn('Require');
        $requireProperty->expects($this->once())
            ->method('getValue')
            ->willReturn('all granted');

        $directoryNode = $this->getMock('Eps\VhostGeneratorBundle\Generator\Node\NodeInterface');
        $directoryNode->expects($this->once())
            ->method('getName')
            ->willReturn('Directory');
        $directoryNode->expects($this->once())
            ->method('getAttributes')
            ->willReturn(
                [
                    DirectoryNode::DIRECTORY_PATH => '/srv/www/someData'
                ]
            );
        $directoryNode->expects($this->once())
            ->method('getProperties')
            ->willReturn(
                [
                    AllowOverrideProperty::NAME => $allowOverrideProperty,
                    AllowProperty::NAME => $allowProperty,
                    RequireProperty::NAME => $requireProperty
                ]
            );

        $vhostNode->expects($this->once())
            ->method('getNodes')
            ->willReturn([$directoryNode]);

        $actual = $formatter->createConfig([$vhostNode]);
        $this->assertEquals($expected, $actual);
    }
}
