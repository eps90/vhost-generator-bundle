<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Apache\Property\Directory;

use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\RequireProperty;

/**
 * Class RequirePropertyTest
 * @package Eps\VhostGeneratorBundle\Tests\Generator\Apache\Property\Directory
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class RequirePropertyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldHaveValidName()
    {
        $propertyValue = 'all granted';
        $property = new RequireProperty($propertyValue);
        $expected = 'Require';
        $actual = $property->getName();
        $this->assertEquals($expected, $actual);
        $this->assertEquals($propertyValue, $property->getValue());
    }
}
