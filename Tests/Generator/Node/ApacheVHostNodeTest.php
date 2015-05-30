<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Node;

use Eps\VhostGeneratorBundle\Generator\Node\ApacheVHostNode;

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
