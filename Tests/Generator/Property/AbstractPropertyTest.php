<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Property;

use Eps\VhostGeneratorBundle\Generator\Property\AbstractProperty;

/**
 * Class AbstractPropertyTest
 * @package Eps\VhostGeneratorBundle\Tests\Generator\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class AbstractPropertyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldContainValue()
    {
        /** @var AbstractProperty $property */
        $property = $this->getMockForAbstractClass(
            'Eps\VhostGeneratorBundle\Generator\Property\AbstractProperty',
            ['PROPERTY_VALUE']
        );

        $actual = $property->getValue();
        $this->assertEquals('PROPERTY_VALUE', $actual);
    }
}
