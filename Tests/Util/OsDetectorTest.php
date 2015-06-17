<?php

namespace Eps\VhostGeneratorBundle\Test\Util;

use Eps\VhostGeneratorBundle\Util\OperatingSystem;
use Eps\VhostGeneratorBundle\Util\OsDetector;

/**
 * Class OsDetectorTest
 * @package Eps\VhostGeneratorBundle\Test\Util
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class OsDetectorTest extends \PHPUnit_Framework_TestCase
{
    public function phpOsProvider()
    {
        return [
            [
                'os' => 'Linux',
                'expected' => OperatingSystem::LINUX
            ],
            [
                'os' => 'linux',
                'expected' => OperatingSystem::LINUX
            ]
        ];
    }

    /**
     * @test
     * @dataProvider phpOsProvider
     */
    public function itShouldDetectOperatingSystem($osName, $expected)
    {
        $os = $this->getMock('Eps\VhostGeneratorBundle\Util\OperatingSystem');
        $os->expects($this->once())
            ->method('getName')
            ->willReturn($osName);

        $osDetector = new OsDetector($os);
        $this->assertEquals($osDetector->detect(), $expected);
    }

    /**
     * @test
     */
    public function itShouldReturnNullIfNoOsFound()
    {
        $os = $this->getMock('Eps\VhostGeneratorBundle\Util\OperatingSystem');
        $os->expects($this->once())
            ->method('getName')
            ->willReturn('jkhdskjhdka');

        $osDetector = new OsDetector($os);
        $this->assertNull($osDetector->detect());
    }
}
