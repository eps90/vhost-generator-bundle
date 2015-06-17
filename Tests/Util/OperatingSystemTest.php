<?php

namespace Eps\VhostGeneratorBundle\Test\Util;

use Eps\VhostGeneratorBundle\Util\OperatingSystem;

/**
 * Class OperatingSystemTest
 * @package Eps\VhostGeneratorBundle\Test\Util
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class OperatingSystemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldReturnSystemSystemName()
    {
        $operatingSystem = new OperatingSystem();
        $this->assertNotEmpty($operatingSystem->getName());
    }
}
