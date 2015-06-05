<?php

namespace Eps\VhostGeneratorBundle\Test\Generator\Apache\Property\VHost;

use Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ErrorLogProperty;

/**
 * Class ErrorLogPropertyTest
 * @package Eps\VhostGeneratorBundle\Test\Generator\Apache\Property\VHost
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ErrorLogPropertyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldHaveValidNameAndValue()
    {
        $property = new ErrorLogProperty('/var/log/apache2/error.log');
        $expected = 'ErrorLog';
        $this->assertEquals($expected, $property->getName());
    }
}
