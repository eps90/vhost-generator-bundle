<?php

namespace Eps\VhostGeneratorBundle\Test\Generator\Apache\Property\Directory;

use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\OrderProperty;

/**
 * Class OrderPropertyTest
 * @package Eps\VhostGeneratorBundle\Test\Generator\Apache\Property\Directory
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class OrderPropertyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldHaveValidName()
    {
        $property = new OrderProperty('Allow,Deny');
        $expectedName = 'Order';
        $this->assertEquals($expectedName, $property->getName());
    }

    public function validValuesProvider()
    {
        return [
            [OrderProperty::ALLOW_DENY],
            [OrderProperty::DENY_ALLOW]
        ];
    }

    /**
     * @test
     * @dataProvider validValuesProvider
     */
    public function itShouldBeAbleToCheckWhetherItIsValid($value)
    {
        $property = new OrderProperty($value);
        $this->assertTrue($property->isValid());
    }

    public function invalidValuesProvider()
    {
        return [
            [[]],
            [''],
            ['NonExistingOption'],
            [null],
            [false]
        ];
    }

    /**
     * @test
     * @dataProvider invalidValuesProvider
     */
    public function itShouldBeAbleToCheckWhetherValueIsInvalid($value)
    {
        $property = new OrderProperty($value);
        $this->assertFalse($property->isValid());
    }

    public function valuesToDetectProvider()
    {
        return [
            [
                'input' => 'allow deny',
                'expected' => 'Allow,Deny'
            ],
            [
                'input' => 'deny allow',
                'expected' => 'Deny,Allow'
            ]
        ];
    }

    /**
     * @test
     * @dataProvider valuesToDetectProvider
     */
    public function itShouldAutomaticallyDetectItsValue($input, $expected)
    {
        $property = new OrderProperty($input);
        $this->assertEquals($expected, $property->getValue());
    }
}
