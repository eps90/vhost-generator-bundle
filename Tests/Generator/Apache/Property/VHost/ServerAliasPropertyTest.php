<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Apache\Property\VHost;

use Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerAliasProperty;

/**
 * Class ServerAliasPropertyTest
 * @package Eps\VhostGeneratorBundle\Tests\Generator\Apache\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ServerAliasPropertyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldHaveName()
    {
        $serverAliasProp = new ServerAliasProperty(['example.com']);
        $expectedName = 'ServerAlias';
        $this->assertEquals($expectedName, $serverAliasProp->getName());
    }

    /**
     * @test
     */
    public function itShouldReturnConcatenatedValuesAsItsValue()
    {
        $serverAliasProp = new ServerAliasProperty(['example.com', 'test.example.com']);
        $expectedValue = 'example.com test.example.com';
        $this->assertEquals($expectedValue, $serverAliasProp->getValue());
    }
}
