<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Apache\Property;

use Eps\VhostGeneratorBundle\Generator\Apache\Property\ServerAliasProperty;

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
        $serverAliasProp = new ServerAliasProperty('example.com');
        $expectedName = 'ServerAlias';
        $this->assertEquals($expectedName, $serverAliasProp->getName());
    }
}
