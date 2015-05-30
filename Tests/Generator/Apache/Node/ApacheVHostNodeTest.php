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
        $expectedName = 'VirtualHost';
        $vhostNode = new ApacheVHostNode();
        $actual = $vhostNode->getName();
        $this->assertEquals($expectedName, $actual);
    }
}
