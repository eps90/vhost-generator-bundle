<?php

namespace Eps\VhostGeneratorBundle\Test\Installer\Apache;

use Eps\VhostGeneratorBundle\Installer\Apache\ApacheInstallerFactory;
use Eps\VhostGeneratorBundle\Util\OperatingSystem;

/**
 * Class ApacheInstallerFactoryTest
 * @package Eps\VhostGeneratorBundle\Test\Installer\Apache
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ApacheInstallerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldFetchProperInstaller()
    {
        $osDetector = $this->getMockBuilder('Eps\VhostGeneratorBundle\Util\OsDetector')
            ->disableOriginalConstructor()
            ->getMock();

        $osDetector->expects($this->once())
            ->method('detect')
            ->willReturn(OperatingSystem::LINUX);

        $linuxInstaller = $this->getMock('Eps\VhostGeneratorBundle\Installer\InstallerInterface');

        $factory = new ApacheInstallerFactory($osDetector);
        $factory->addInstaller('linux', $linuxInstaller);

        $actual = $factory->getInstaller();
        $this->assertEquals($linuxInstaller, $actual);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function itShouldThrowIfInstallerHasNotBeenFound()
    {
        $osDetector = $this->getMockBuilder('Eps\VhostGeneratorBundle\Util\OsDetector')
            ->disableOriginalConstructor()
            ->getMock();

        $osDetector->expects($this->once())
            ->method('detect')
            ->willReturn(OperatingSystem::UNKNOWN);

        $linuxInstaller = $this->getMock('Eps\VhostGeneratorBundle\Installer\InstallerInterface');

        $factory = new ApacheInstallerFactory($osDetector);
        $factory->addInstaller('linux', $linuxInstaller);

        $factory->getInstaller();
    }
}
