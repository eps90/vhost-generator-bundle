<?php

namespace Eps\VhostGeneratorBundle\Test\Generator\Apache\Property\Directory;

use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\DenyProperty;

/**
 * Class DenyPropertyTest
 * @package Eps\VhostGeneratorBundle\Test\Generator\Apache\Property\Directory
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class DenyPropertyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldHaveValidName()
    {
        $property = new DenyProperty('all');
        $expectedName = 'Deny';
        $this->assertEquals($expectedName, $property->getName());
    }

    /**
     * @test
     */
    public function itShouldHaveValidValue()
    {
        $property = new DenyProperty('all');
        $expectedValue = 'from all';
        $this->assertEquals($expectedValue, $property->getValue());
        $this->assertTrue($property->isValid());
    }
}
