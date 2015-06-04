<?php

namespace Eps\VhostGeneratorBundle\Test\Generator\Property;

use Eps\VhostGeneratorBundle\Generator\Property\MultipleOptionsProperty;

/**
 * Class MultipleOptionsPropertyTest
 * @package Eps\VhostGeneratorBundle\Test\Generator\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class MultipleOptionsPropertyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldBeValidOnlyWithArrayValues()
    {
        $values = [
            'a',
            'b'
        ];
        /** @var MultipleOptionsProperty $property */
        $property = $this->getMockForAbstractClass(
            'Eps\VhostGeneratorBundle\Generator\Property\MultipleOptionsProperty',
            [$values]
        );
        $this->assertTrue($property->isValid());
    }

    public function invalidValuesProvider()
    {
        return [
            [['']],
            [[]],
            [[null]]
        ];
    }

    /**
     * @test
     * @dataProvider invalidValuesProvider
     */
    public function itShouldBeNotValidForNonArrayValues($value)
    {
        /** @var MultipleOptionsProperty $property */
        $property = $this->getMockForAbstractClass(
            'Eps\VhostGeneratorBundle\Generator\Property\MultipleOptionsProperty',
            [$value]
        );
        $this->assertFalse($property->isValid());
    }
}
