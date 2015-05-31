<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Apache\Property\Directory;

use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\AllowProperty;

/**
 * Class AllowPropertyTest
 * @package Eps\VhostGeneratorBundle\Tests\Generator\Apache\Property\Directory
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class AllowPropertyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldHaveValidName()
    {
        $property = new AllowProperty('all');
        $expected = 'Allow';
        $actual = $property->getName();
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function itShouldHaveValidValue()
    {
        $inputValue = '10.0.0.1';
        $property = new AllowProperty($inputValue);
        $expected = 'from 10.0.0.1';
        $actual = $property->getValue();
        $this->assertEquals($expected, $actual);
    }
}
