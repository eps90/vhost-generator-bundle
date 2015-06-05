<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Apache\Property\Directory;

use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\OptionsProperty;

/**
 * Class OptionsPropertyTest
 * @package Eps\VhostGeneratorBundle\Tests\Generator\Apache\Property\Directory
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class OptionsPropertyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldHaveValidName()
    {
        $property = new OptionsProperty([OptionsProperty::ALL]);
        $actual = $property->getName();
        $expected = 'Options';
        $this->assertEquals($expected, $actual);
    }

    public function validValuesProvider()
    {
        return [
            [OptionsProperty::ALL],
            [OptionsProperty::NONE],
            [OptionsProperty::EXEC_GGI],
            [OptionsProperty::FOLLOW_SYM_LINKS],
            [OptionsProperty::INCLUDES],
            [OptionsProperty::INCLUDES_NO_EXEC],
            [OptionsProperty::INDEXES],
            [OptionsProperty::MULTI_VIEWS],
            [OptionsProperty::SYM_LINKS_IF_OWNER_MATCH]
        ];
    }

    /**
     * @test
     * @dataProvider validValuesProvider
     */
    public function itShouldBeAbleToSetOptionValue($optionValue)
    {
        $property = new OptionsProperty([$optionValue => true]);
        $actual = $property->getOptions();
        $expected = [
            $optionValue => true
        ];
        $this->assertEquals($expected, $actual);
        $this->assertTrue($property->isValid());
    }

    public function invalidOptionsProvider()
    {
        return [
            [['SomeNonExistingProperty']],
            [[null]],
            [[]],
            [['']]
        ];
    }

    /**
     * @test
     * @dataProvider invalidOptionsProvider
     */
    public function itShouldDetermineWhetherOptionsAreValid($options)
    {
        $property = new OptionsProperty($options);
        $this->assertFalse($property->isValid());
    }

    /**
     * @test
     */
    public function itShouldAcceptSimpleArrays()
    {
        $property = new OptionsProperty([OptionsProperty::EXEC_GGI]);
        $expected = [
            OptionsProperty::EXEC_GGI => true
        ];
        $actual = $property->getOptions();
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function itShouldFilterOutAllValuesButMultiViewsIfOptionsContainAll()
    {
        $options = [
            OptionsProperty::INCLUDES => true,
            OptionsProperty::INDEXES => false,
            OptionsProperty::ALL => true,
            OptionsProperty::MULTI_VIEWS => true
        ];
        $property = new OptionsProperty($options);
        $expected = [
            OptionsProperty::ALL => true,
            OptionsProperty::MULTI_VIEWS => true
        ];
        $actual = $property->getOptions();
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function itShouldFilterOutAllValuesIfOptionsContainNone()
    {
        $options = [
            OptionsProperty::INCLUDES => true,
            OptionsProperty::INDEXES => false,
            OptionsProperty::NONE => true
        ];
        $property = new OptionsProperty($options);
        $expected = [
            OptionsProperty::NONE => true
        ];
        $actual = $property->getOptions();
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function itShouldContainAllIfAllAndNoneInOptions()
    {
        $options = [
            OptionsProperty::ALL,
            OptionsProperty::NONE
        ];
        $expected = [
            OptionsProperty::ALL => true
        ];

        $property = new OptionsProperty($options);
        $acutal = $property->getOptions();
        $this->assertEquals($expected, $acutal);
    }

    public function optionsStringProvider()
    {
        return [
            [
                'options' => [
                    OptionsProperty::EXEC_GGI => true,
                    OptionsProperty::FOLLOW_SYM_LINKS => true,
                ],
                'optionsString' => 'ExecCGI FollowSymLinks'
            ],
            [
                'options' => [
                    OptionsProperty::INDEXES => true,
                    OptionsProperty::INCLUDES => false
                ],
                'optionsString' => '+Indexes -Includes'
            ],
            [
                'options' => [
                    OptionsProperty::ALL
                ],
                'optionsString' => 'All'
            ],
            [
                'options' => [
                    OptionsProperty::NONE
                ],
                'optionsString' => 'None'
            ],
            [
                'options' => [
                    OptionsProperty::ALL,
                    OptionsProperty::NONE
                ],
                'optionsString' => 'All'
            ],
            [
                'options' => [
                    OptionsProperty::ALL => true,
                    OptionsProperty::MULTI_VIEWS => true
                ],
                'optionsString' => 'All MultiViews'
            ],
            [
                'options' => [
                    OptionsProperty::INDEXES => false,
                    OptionsProperty::INCLUDES_NO_EXEC => false
                ],
                'optionsString' => '-Indexes -IncludesNOEXEC'
            ]
        ];
    }

    /**
     * @test
     * @dataProvider optionsStringProvider
     */
    public function itShouldRenderOptionsString($options, $expected)
    {
        $property = new OptionsProperty($options);
        $actual = $property->getValue();
        $this->assertEquals($expected, $actual);
    }

    public function toDetectValuesProvider()
    {
        return [
            [
                'options' => ['all'],
                'expected' => [OptionsProperty::ALL => true]
            ],
            [
                'options' => ['exec_cgi' => true],
                'expected' => [OptionsProperty::EXEC_GGI => true]
            ],
            [
                'options' => ['execcgi'],
                'expected' => [OptionsProperty::EXEC_GGI => true]
            ],
            [
                'options' => ['EXECCGI'],
                'expected' => [OptionsProperty::EXEC_GGI => true]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider toDetectValuesProvider
     */
    public function itShouldAutomaticallyDetectCorrectValue($options, $expected)
    {
        $optionsProperty = new OptionsProperty($options);
        $this->assertEquals($expected, $optionsProperty->getOptions());
        $this->assertTrue($optionsProperty->isValid());
    }
}
