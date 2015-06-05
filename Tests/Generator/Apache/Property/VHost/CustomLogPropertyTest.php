<?php

namespace Eps\VhostGeneratorBundle\Test\Generator\Apache\Property\VHost;

use Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\CustomLogProperty;

/**
 * Class CustomLogPropertyTest
 * @package Eps\VhostGeneratorBundle\Test\Generator\Apache\Property\VHost
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class CustomLogPropertyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldHaveValidName()
    {
        $property = new CustomLogProperty('/var/log/apache2/access.log');
        $expectedName = 'CustomLog';
        $this->assertEquals($expectedName, $property->getName());
    }

    /**
     * @test
     */
    public function itShouldHaveValidValue()
    {
        $property = new CustomLogProperty('/var/log/apache2/access.log');
        $expectedValue = '/var/log/apache2/access.log combined';
        $this->assertEquals($expectedValue, $property->getValue());
        $this->assertTrue($property->isValid());
    }
}
