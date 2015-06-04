<?php

namespace Eps\VhostGeneratorBundle\Test\Generator\Property;

use Eps\VhostGeneratorBundle\Generator\Property\StringProperty;

/**
 * Class StringPropertyTest
 * @package Eps\VhostGeneratorBundle\Test\Generator\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class StringPropertyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldAcceptStringValues()
    {
        /** @var StringProperty $property */
        $property = $this->getMockForAbstractClass(
            'Eps\VhostGeneratorBundle\Generator\Property\StringProperty',
            ['PROPERTY_VALUE']
        );
        $this->assertTrue($property->isValid());
    }

    public function invalidValuesProvider()
    {
        return [
            [null],
            [''],
            [[]],
            [new \stdClass()],
            [123],
            [true]
        ];
    }

    /**
     * @test
     * @dataProvider invalidValuesProvider
     */
    public function itShouldNotAcceptNonStringValues($value)
    {
        /** @var StringProperty $property */
        $property = $this->getMockForAbstractClass(
            'Eps\VhostGeneratorBundle\Generator\Property\StringProperty',
            [$value]
        );
        $this->assertFalse($property->isValid());
    }
}
