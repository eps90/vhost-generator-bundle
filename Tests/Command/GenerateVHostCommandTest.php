<?php

namespace Eps\VhostGeneratorBundle\Tests\Command;

use Eps\VhostGeneratorBundle\Command\GenerateVHostCommand;
use Eps\VhostGeneratorBundle\Tests\Util\SymfonyProcessFactoryTest;
use Symfony\Component\Console\Helper\HelperInterface;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class GenerateVHostCommandTest
 * @package Command
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class GenerateVHostCommandTest extends \PHPUnit_Framework_TestCase
{
    private $processesCounter = 0;

    /**
     * @test
     */
    public function isShouldHaveValidConfig()
    {
        $command = new GenerateVHostCommand();
        $this->assertEquals('vhost:generate', $command->getName());
        $this->assertNotEmpty($command->getDescription());
    }

    /**
     * @test
     */
    public function itShouldGenerateApacheConfig()
    {
        $installer = $this->getMock('Eps\VhostGeneratorBundle\Installer\InstallerInterface');
        $installer->expects($this->once())
            ->method('install');

        $helpers = $this->getHelpers();
        $helpers['question']->expects($this->once())
            ->method('ask')
            ->willReturn(true);

        $command = new GenerateVHostCommand();
        $command->setHelperSet(new HelperSet($helpers));
        $command->setInstaller($installer);

        $input = $this->getMock('Symfony\Component\Console\Input\InputInterface');
        $output = $this->getMock('Symfony\Component\Console\Output\OutputInterface');

        $command->run($input, $output);
    }

    /**
     * @test
     */
    public function itShouldDoNothingIfUserDoesNotAcceptConfirmation()
    {
        $helpers = $this->getHelpers();
        $helpers['question']->expects($this->once())
            ->method('ask')
            ->willReturn(false);


        $installer = $this->getMock('Eps\VhostGeneratorBundle\Installer\InstallerInterface');
        $installer->expects($this->never())
            ->method('install');

        $command = new GenerateVHostCommand();
        $command->setHelperSet(new HelperSet($helpers));
        $command->setInstaller($installer);

        $input = $this->getMock('Symfony\Component\Console\Input\InputInterface');
        $output = $this->getMock('Symfony\Component\Console\Output\OutputInterface');

        $command->run($input, $output);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject[]
     */
    private function getHelpers()
    {
        $helpers = [];

        $questionHelper = $this->getMockBuilder('Symfony\Component\Console\Helper\HelperInterface')
            ->setMethods(['getName', 'setHelperSet', 'getHelperSet', 'ask'])
            ->getMock();
        $questionHelper->expects($this->once())
            ->method('getName')
            ->willReturn('question');
        $helpers['question'] = $questionHelper;

        $formatterHelper = $this->getMockBuilder('Symfony\Component\Console\Helper\HelperInterface')
            ->setMethods(['getName', 'setHelperSet', 'getHelperSet', 'formatBlock'])
            ->getMock();
        $formatterHelper->expects($this->once())
            ->method('formatBlock')
            ->willReturn('');
        $helpers['formatter'] = $formatterHelper;

        return $helpers;
    }
}
