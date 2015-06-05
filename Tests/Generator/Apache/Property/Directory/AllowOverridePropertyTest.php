<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Apache\Property\Directory;

use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\AllowOverrideProperty;

/**
 * Class AllowOverridePropertyTest
 * @package Eps\VhostGeneratorBundle\Tests\Generator\Apache\Property\Directory
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class AllowOverridePropertyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldHaveValidName()
    {
        $property = new AllowOverrideProperty([]);
        $expectedName = 'AllowOverride';
        $actualName = $property->getName();
        $this->assertEquals($expectedName, $actualName);
    }

    public function validOptionsProvider()
    {
        return [
            [AllowOverrideProperty::ALL],
            [AllowOverrideProperty::NONE],
            [AllowOverrideProperty::AUTH_CONFIG],
            [AllowOverrideProperty::FILE_INFO],
            [AllowOverrideProperty::INDEXES],
            [AllowOverrideProperty::LIMIT],
            [AllowOverrideProperty::NONFATAL_ALL],
            [AllowOverrideProperty::NONFATAL_UNKNOWN],
            [AllowOverrideProperty::NONFATAL_OVERRIDE]
        ];
    }

    /**
     * @test
     * @dataProvider validOptionsProvider
     */
    public function itShouldAllowToSetValidOptions($option)
    {
        $property = new AllowOverrideProperty([$option]);
        $actual = $property->getOptions();
        $expected = [
            $option
        ];
        $this->assertEquals($expected, $actual);
        $this->assertTrue($property->isValid());
    }

    public function invalidValuesProvider()
    {
        return [
            [['SomeNoExistingValue']],
            [[]],
            [[null]]
        ];
    }

    /**
     * @test
     * @dataProvider invalidValuesProvider
     */
    public function itShouldCheckWhetherValuesAreInvalid($options)
    {
        $property = new AllowOverrideProperty($options);
        $this->assertFalse($property->isValid());
    }

    /**
     * @test
     */
    public function itShouldFilterOutAllValuesButAllIfOptionsContainAll()
    {
        $options = [
            AllowOverrideProperty::INDEXES,
            AllowOverrideProperty::AUTH_CONFIG,
            AllowOverrideProperty::ALL
        ];

        $property = new AllowOverrideProperty($options);
        $expected = [
            AllowOverrideProperty::ALL
        ];
        $actual = $property->getOptions();
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function itShouldFilterOutAllValuesButNoneIfOptionsContainNone()
    {
        $options = [
            AllowOverrideProperty::INDEXES,
            AllowOverrideProperty::AUTH_CONFIG,
            AllowOverrideProperty::NONE
        ];

        $property = new AllowOverrideProperty($options);
        $expected = [
            AllowOverrideProperty::NONE
        ];
        $actual = $property->getOptions();
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function itShouldContainAllOptionIfAllAndNoneProvided()
    {
        $options = [
            AllowOverrideProperty::INDEXES,
            AllowOverrideProperty::AUTH_CONFIG,
            AllowOverrideProperty::NONE,
            AllowOverrideProperty::ALL
        ];

        $property = new AllowOverrideProperty($options);
        $expected = [
            AllowOverrideProperty::ALL
        ];
        $actual = $property->getOptions();
        $this->assertEquals($expected, $actual);
    }

    public function optionsStringProvider()
    {
        return [
            [
                'options' => [
                    AllowOverrideProperty::AUTH_CONFIG,
                    AllowOverrideProperty::INDEXES
                ],
                'optionsString' => 'AuthConfig Indexes'
            ],
            [
                'options' => [
                    AllowOverrideProperty::INDEXES,
                    AllowOverrideProperty::ALL
                ],
                'optionsString' => 'All'
            ],
            [
                'options' => [
                    AllowOverrideProperty::INDEXES,
                    AllowOverrideProperty::NONE
                ],
                'optionsString' => 'None'
            ]
        ];
    }

    /**
     * @test
     * @dataProvider optionsStringProvider
     */
    public function itShouldRenderOptionsAsString($options, $expected)
    {
        $property = new AllowOverrideProperty($options);
        $actual = $property->getValue();
        $this->assertEquals($expected, $actual);
    }

    public function toDetectValuesProvider()
    {
        return [
            [
                'options' => ['all'],
                'expected' => [AllowOverrideProperty::ALL]
            ],
            [
                'options' => ['auth_config'],
                'expected' => [AllowOverrideProperty::AUTH_CONFIG]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider toDetectValuesProvider
     */
    public function itShouldAutomaticallyDetectConfigKey($options, $expected)
    {
        $allowOverrideProperty = new AllowOverrideProperty($options);
        $this->assertEquals($expected, $allowOverrideProperty->getOptions());
        $this->assertTrue($allowOverrideProperty->isValid());
    }
}
