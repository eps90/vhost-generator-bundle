<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Apache\Property;

use Eps\VhostGeneratorBundle\Generator\Apache\Property\ServerNameProperty;

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

    /**
     * @test
     */
    public function itShouldHasValidValue()
    {
        $serverName = 'www.example.com';
        $property = new ServerNameProperty($serverName);
        $this->assertSame($serverName, $property->getValue());
        $this->assertTrue($property->isValid());
    }

    /**
     * @test
     */
    public function itShouldDetermineWhetherValueIsValid()
    {
        $invalidServerName = 'kjfdkljfs';
        $property = new ServerNameProperty($invalidServerName);
        $this->assertFalse($property->isValid());
    }
}
