<?php

namespace Eps\VhostGeneratorBundle\Tests\Util;

use Eps\VhostGeneratorBundle\Util\SymfonyProcessFactory;

/**
 * Class SymfonyProcessFactoryTest
 * @package Eps\VhostGeneratorBundle\Tests\Util
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class SymfonyProcessFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldGenerateProcessObject()
    {
        $factory = new SymfonyProcessFactory();
        $actual = $factory->getProcess('some command');
        $this->assertInstanceOf('Symfony\Component\Process\Process', $actual);
        $this->assertEquals('some command', $actual->getCommandLine());
    }
}
