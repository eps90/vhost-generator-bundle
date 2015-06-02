<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Apache;

use Eps\VhostGeneratorBundle\Generator\Apache\ApacheGenerator;

/**
 * Class ApacheGeneratorTest
 * @package Eps\VhostGeneratorBundle\Tests\Generator\Apache
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ApacheGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function isShouldGenerateConfigForGivenConfigValues()
    {
        $config = ['some_config'];

        $node = $this->getMock('Eps\VhostGeneratorBundle\Generator\Node\NodeInterface');

        $factory = $this->getMock('Eps\VhostGeneratorBundle\Generator\Node\Factory\NodeFactoryInterface');
        $factory->expects($this->once())
            ->method('createNodes')
            ->with($config)
            ->willReturn($node);

        $formatter = $this->getMock('Eps\VhostGeneratorBundle\Generator\Formatter\ConfigurationFormatterInterface');
        $formatter->expects($this->once())
            ->method('createConfig')
            ->with([$node])
            ->willReturn('some config text');

        $generator = new ApacheGenerator($factory, $formatter);
        $actual = $generator->generate($config);
        $this->assertEquals('some config text', $actual);
    }
}
