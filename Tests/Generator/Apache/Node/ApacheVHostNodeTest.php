<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Apache\Node;

use Eps\VhostGeneratorBundle\Generator\Apache\Node\ApacheVHostNode;

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
}
