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
     * @test
     */
    public function itShouldContainValue()
    {
        /** @var Property $property */
        $property = $this->getMockForAbstractClass(
            'Eps\VhostGeneratorBundle\Generator\Property\Property',
            ['PROPERTY_VALUE']
        );

        $actual = $property->getValue();
        $this->assertEquals('PROPERTY_VALUE', $actual);
    }
}
