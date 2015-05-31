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
        $property = new AllowOverrideProperty(null);
        $expectedName = 'AllowOverride';
        $actualName = $property->getName();
        $this->assertEquals($expectedName, $actualName);
    }
}
