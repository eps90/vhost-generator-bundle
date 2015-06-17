<?php

namespace Eps\VhostGeneratorBundle\Test\Installer\Apache;

use Eps\VhostGeneratorBundle\Installer\Apache\LinuxInstaller;

/**
 * Class LinuxInstallerTest
 * @package Eps\VhostGeneratorBundle\Test\Installer\Apache
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class LinuxInstallerTest extends \PHPUnit_Framework_TestCase
{
    private $processesCounter = 0;

    /**
     * @test
     */
    public function itShouldApplyAConfigOnSystem()
    {
        $processFactory = $this->getMockBuilder('Eps\VhostGeneratorBundle\Util\SymfonyProcessFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $filesystem = $this->getMockBuilder('Symfony\Component\Filesystem\Filesystem')
            ->disableOriginalConstructor()
            ->getMock();

        $generator = $this->getMock('Eps\VhostGeneratorBundle\Generator\GeneratorInterface');

        $vhostsPath = '/etc/apache/sites-available';
        $outputFile = 'prod.conf';
        $vhostsConfig = ['a' => 'b'];

        $installer = new LinuxInstaller($filesystem, $processFactory);
        $installer->setVHostsPath($vhostsPath);
        $installer->setOutputFile($outputFile);
        $installer->setVHosts($vhostsConfig);
        $installer->setGenerator($generator);

        // ============

        $configContents = 'abc';
        $generator->expects($this->once())
            ->method('generate')
            ->with($vhostsConfig)
            ->willReturn($configContents);

        $tmpFileName = '/tmp/vhost_' . substr(md5($configContents), 0, 7);
        $filesystem->expects($this->atLeastOnce())
            ->method('dumpFile')
            ->with($tmpFileName, $configContents);

        $this->expectProcess($processFactory, "sudo cp $tmpFileName {$vhostsPath}/$outputFile", true);
        $this->expectProcess($processFactory, "sudo a2ensite $outputFile", true);
        $this->expectProcess($processFactory, 'sudo service apache2 reload', true);

        $installer->install();
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function itShouldThrowIfProcessIsNotSuccessful()
    {
        $processFactory = $this->getMockBuilder('Eps\VhostGeneratorBundle\Util\SymfonyProcessFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $filesystem = $this->getMockBuilder('Symfony\Component\Filesystem\Filesystem')
            ->disableOriginalConstructor()
            ->getMock();

        $generator = $this->getMock('Eps\VhostGeneratorBundle\Generator\GeneratorInterface');

        $vhostsPath = '/etc/apache/sites-available';
        $outputFile = 'prod.conf';
        $vhostsConfig = ['a' => 'b'];

        $installer = new LinuxInstaller($filesystem, $processFactory);
        $installer->setVHostsPath($vhostsPath);
        $installer->setOutputFile($outputFile);
        $installer->setVHosts($vhostsConfig);
        $installer->setGenerator($generator);

        // ============

        $configContents = 'abc';
        $generator->expects($this->once())
            ->method('generate')
            ->with($vhostsConfig)
            ->willReturn($configContents);

        $tmpFileName = '/tmp/vhost_' . substr(md5($configContents), 0, 7);
        $filesystem->expects($this->atLeastOnce())
            ->method('dumpFile')
            ->with($tmpFileName, $configContents);

        $this->expectProcess($processFactory, "sudo cp $tmpFileName {$vhostsPath}/$outputFile", false);

        $installer->install();
    }

    private function expectProcess(\PHPUnit_Framework_MockObject_MockObject $processFactory, $command, $isSuccessful)
    {
        $process = $this->getMockBuilder('Symfony\Component\Process\Process')
            ->disableOriginalConstructor()
            ->getMock();
        $process->expects($this->atLeastOnce())
            ->method('isSuccessful')
            ->willReturn($isSuccessful);
        $process->expects($this->once())
            ->method('run');

        $processFactory->expects($this->at($this->processesCounter++))
            ->method('getProcess')
            ->with($command)
            ->willReturn($process);
    }
}
