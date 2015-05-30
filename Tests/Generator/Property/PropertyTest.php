<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Property;

use Eps\VhostGeneratorBundle\Generator\Property\Property;

/**
 * Class PropertyTest
 * @package Eps\VhostGeneratorBundle\Tests\Generator\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class PropertyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Property
     */
    private $property;

    /**
     * @before
     */
    public function before()
    {
        $this->property = new Property('PROPERTY_NAME', 'PROPERTY_VALUE');
    }

    /**
     * @test
     */
    public function itShouldContainName()
    {
        $actual = $this->property->getName();
        $this->assertEquals('PROPERTY_NAME', $actual);
    }

    /**
     * @test
     */
    public function itShouldContainValue()
    {
        $actual = $this->property->getValue();
        $this->assertEquals('PROPERTY_VALUE', $actual);
    }
}
