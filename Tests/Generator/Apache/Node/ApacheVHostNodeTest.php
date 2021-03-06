<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Apache\Node;

use Eps\VhostGeneratorBundle\Generator\Apache\Node\ApacheVHostNode;
use Eps\VhostGeneratorBundle\Generator\Apache\Node\DirectoryNode;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\CustomLogProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\DocumentRootProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ErrorLogProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerAliasProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerNameProperty;
use org\bovigo\vfs\vfsStream;

/**
 * Class ApacheVHostNodeTest
 * @package Eps\VhostGeneratorBundle\Tests\Generator\Apache\Node
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ApacheVHostNodeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldReturnItsName()
    {
        $vhostNode = new ApacheVHostNode();
        $expectedName = 'VirtualHost';
        $actual = $vhostNode->getName();
        $this->assertEquals($expectedName, $actual);
    }

    /**
     * @test
     */
    public function itShouldHaveWildcardAddressAttributeByDefault()
    {
        $vhostNode = new ApacheVHostNode();
        $expectedAttributes = [
            ApacheVHostNode::ADDRESS => '*:80'
        ];
        $actual = $vhostNode->getAttributes();
        $this->assertEquals($expectedAttributes, $actual);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToSetIpAddress()
    {
        $vhostNode = new ApacheVHostNode();

        $vhostNode->setAddress('127.0.0.1');
        $expected = [
            ApacheVHostNode::ADDRESS => '127.0.0.1:80'
        ];
        $actual = $vhostNode->getAttributes();
        $this->assertEquals($expected, $actual);

        $vhostNode->setAddress('*', 443);
        $expected = [
            ApacheVHostNode::ADDRESS => '*:443'
        ];
        $actual = $vhostNode->getAttributes();
        $this->assertEquals($expected, $actual);
    }

    public function invalidAddressesProvider()
    {
        return [
            'wrong_ip' => [
                'ip_address' => '127.0.0.0.0.0.1',
                'port' => '80'
            ],
            'wrong port' => [
                'ip_addres' => '*',
                'port' => 'a80ba'
            ],
            'port_exceeded_limit_of_65535' => [
                'ip_address' => '*',
                'port' => '90843028028'
            ]
        ];
    }

    /**
     * @test
     * @expectedException \Eps\VHostGeneratorBundle\Generator\Exception\ValidationException
     * @expectedExceptionMessageRegExp /Invalid IP address or port number (.+:.+)/
     * @dataProvider invalidAddressesProvider
     */
    public function itShouldNotAllowToSetInvalidAddress($ipAddress, $port)
    {
        $vhostNode = new ApacheVHostNode();
        $vhostNode->setAddress($ipAddress, $port);
    }

    /**
     * @test
     */
    public function itShouldAllowToAddDocumentRootAsString()
    {
        $vhostNode = new ApacheVHostNode();

        $structure = [
            'srv' => [
                'www' => [
                    'myDir' => [
                        'sample_file.php' => '<?php echo "OK"; ?>'
                    ]
                ]
            ]
        ];
        $fileSystem = vfsStream::setup('root', null, $structure);
        $filePath = $fileSystem->url() . '/srv/www/myDir';
        $vhostNode->setDocumentRoot($filePath);
        $parameters = $vhostNode->getProperties();

        /** @var DocumentRootProperty $documentRoot */
        $documentRoot = $parameters[DocumentRootProperty::NAME];
        $this->assertInstanceOf(
            'Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\DocumentRootProperty',
            $documentRoot
        );
        $this->assertEquals($documentRoot->getValue(), $filePath);
    }

    /**
     * @test
     */
    public function itShouldAllowToAddDocumentRootAsObject()
    {
        $vhostNode = new ApacheVHostNode();

        $structure = [
            'srv' => [
                'www' => [
                    'myDir' => [
                        'sample_file.php' => '<?php echo "OK"; ?>'
                    ]
                ]
            ]
        ];
        $fileSystem = vfsStream::setup('root', null, $structure);
        $filePath = $fileSystem->url() . '/srv/www/myDir';
        $documentRootProp = new DocumentRootProperty($filePath);
        $vhostNode->setDocumentRoot($documentRootProp);
        $parameters = $vhostNode->getProperties();

        /** @var DocumentRootProperty $documentRoot */
        $documentRoot = $parameters[DocumentRootProperty::NAME];
        $this->assertInstanceOf(
            'Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\DocumentRootProperty',
            $documentRoot
        );
        $this->assertEquals($documentRoot->getValue(), $filePath);
    }

    /**
     * @test
     * @expectedException \Eps\VHostGeneratorBundle\Generator\Exception\ValidationException
     */
    public function itShouldThrowIfDocumentRootIsInvalid()
    {
        $vhostNode = new ApacheVHostNode();
        $documentRootProp = $this->getMockBuilder(
            'Eps\VHostGeneratorBundle\Generator\Apache\Property\VHost\DocumentRootproperty'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $documentRootProp->expects($this->once())
            ->method('isValid')
            ->willReturn(false);

        $vhostNode->setDocumentRoot($documentRootProp);
    }

    /**
     * @test
     */
    public function itShouldAllowToSetServerName()
    {
        $serverNameProp = 'www.example.com';
        $vhostName = new ApacheVHostNode();
        $vhostName->setServerName($serverNameProp);

        /** @var ServerNameProperty $serverName */
        $serverName = $vhostName->getProperties()[ServerNameProperty::NAME];
        $this->assertInstanceOf(
            'Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerNameProperty',
            $serverName
        );
        $this->assertEquals($serverName->getValue(), $serverNameProp);
    }

    /**
     * @test
     * @expectedException \Eps\VHostGeneratorBundle\Generator\Exception\ValidationException
     */
    public function itShouldThrowIfServerNamePropertyIsNotValid()
    {
        $serverNameProp = $this->getMockBuilder(
            'Eps\VHostGeneratorBundle\Generator\Apache\Property\VHost\ServerNameProperty'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $serverNameProp->expects($this->once())
            ->method('isValid')
            ->willReturn(false);

        $vhostName = new ApacheVHostNode();
        $vhostName->setServerName($serverNameProp);
    }

    /**
     * @test
     */
    public function itShouldAllowToSetServerAliases()
    {
        $serverAliasProp = ['www.example.com'];
        $vhostNode = new ApacheVHostNode();
        $vhostNode->setServerAliases($serverAliasProp);

        /** @var ServerAliasProperty $serverAlias */
        $serverAlias = $vhostNode->getProperties()[ServerAliasProperty::NAME];
        $this->assertInstanceOf(
            'Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerAliasProperty',
            $serverAlias
        );
        $this->assertEquals('www.example.com', $serverAlias->getValue());
    }

    /**
     * @test
     * @expectedException \Eps\VHostGeneratorBundle\Generator\Exception\ValidationException
     */
    public function itShouldThrowIfServerAliasPropertyIsNotValid()
    {
        $serverNameProp = $this->getMockBuilder(
            'Eps\VHostGeneratorBundle\Generator\Apache\Property\VHost\ServerAliasProperty'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $serverNameProp->expects($this->once())
            ->method('isValid')
            ->willReturn(false);

        $vhostName = new ApacheVHostNode();
        $vhostName->setServerAliases($serverNameProp);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToAddDirectoryNode()
    {
        $node = new ApacheVHostNode();
        $directoryNode = new DirectoryNode();
        $node->addDirectoryNode($directoryNode);
        $expected = [$directoryNode];
        $actual = $node->getNodes();
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function itShouldBeAbletoAddErrorLogProperty()
    {
        $errorLogProperty = '/var/log/apache2/error.log';
        $vhostNode = new ApacheVHostNode();
        $vhostNode->setErrorLog($errorLogProperty);

        /** @var ErrorLogProperty $errorLog */
        $errorLog = $vhostNode->getProperties()[ErrorLogProperty::NAME];
        $this->assertInstanceOf(
            'Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ErrorLogProperty',
            $errorLog
        );
        $this->assertEquals($errorLogProperty, $errorLog->getValue());
    }

    /**
     * @test
     */
    public function itShouldBeAbletoAddCustomLogProperty()
    {
        $customLogProperty = '/var/log/apache2/access.log';
        $vhostNode = new ApacheVHostNode();
        $vhostNode->setCustomLog($customLogProperty);

        /** @var CustomLogProperty $customLog */
        $customLog = $vhostNode->getProperties()[CustomLogProperty::NAME];
        $this->assertInstanceOf(
            'Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\CustomLogProperty',
            $customLog
        );
        $this->assertEquals('/var/log/apache2/access.log combined', $customLog->getValue());
    }
}
