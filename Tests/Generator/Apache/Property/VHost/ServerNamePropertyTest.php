<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Apache\Property\VHost;

use Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerNameProperty;

/**
 * Class ServerNamePropertyTest
 * @package Eps\VhostGeneratorBundle\Tests\Generator\Apache\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ServerNamePropertyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldHaveValidName()
    {
        $property = new ServerNameProperty('some_server_name');
        $expected = 'ServerName';
        $actual = $property->getName();
        $this->assertEquals($expected, $actual);
    }

    public function validServerNameProvider()
    {
        return [
            ['example.com'],
            ['www.example.com'],
            ['localhost'],
            ['*.example.com']
        ];
    }

    /**
     * @test
     * @dataProvider validServerNameProvider
     */
    public function itShouldHasValidValue($validServerName)
    {
        $property = new ServerNameProperty($validServerName);
        $this->assertSame($validServerName, $property->getValue());
        $this->assertTrue($property->isValid());
    }

    public function invalidServerNameProvider()
    {
        return [
            [['kjklfj']],
            [null],
            [new \stdClass],
            ['']
        ];
    }

    /**
     * @test
     * @dataProvider invalidServerNameProvider
     */
    public function itShouldDetermineWhetherValueIsValid($invalidServerName)
    {
        $property = new ServerNameProperty($invalidServerName);
        $this->assertFalse($property->isValid());
    }
}
