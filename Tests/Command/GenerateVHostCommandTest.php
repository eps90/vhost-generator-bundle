<?php

namespace Command;

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
        $sampleConfig = [
            'prod' => [
                'server_name' => 'example.com'
            ]
        ];
        $vhostsPath = '/etc/apache2/sites-available';
        $generatedConfig = 'some config';
        $tmpFilePath = '/tmp/vhost_a24b250';
        $outputFile = 'prod.conf';


        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $container->expects($this->at(0))
            ->method('getParameter')
            ->with('vhost_generator.apache.vhosts')
            ->willReturn($sampleConfig);
        $container->expects($this->at(1))
            ->method('getParameter')
            ->with('vhost_generator.apache.vhosts_path')
            ->willReturn($vhostsPath);
        $container->expects($this->at(2))
            ->method('getParameter')
            ->with('vhost_generator.apache.output_file')
            ->willReturn('prod.conf');

        $generator = $this->getMock('Eps\VhostGeneratorBundle\Generator\GeneratorInterface');
        $generator->expects($this->once())
            ->method('generate')
            ->with($sampleConfig)
            ->willReturn($generatedConfig);

        $fileSystem = $this->getMock('Symfony\Component\Filesystem\Filesystem');
        $fileSystem->expects($this->once())
            ->method('dumpFile')
            ->with($tmpFilePath, $generatedConfig);

        $processOne = $this->getMockBuilder('Symfony\Component\Process\Process')
            ->disableOriginalConstructor()
            ->getMock();

        $processTwo = clone $processOne;
        $processThree = clone $processOne;

        $processFactory = $this->getMock('Eps\VhostGeneratorBundle\Util\SymfonyProcessFactory');
        $processFactory->expects($this->at(0))
            ->method('getProcess')
            ->with("sudo cp $tmpFilePath {$vhostsPath}/$outputFile")
            ->willReturn($processOne);

        $processFactory->expects($this->at(1))
            ->method('getProcess')
            ->with("sudo a2ensite $outputFile")
            ->willReturn($processTwo);

        $processFactory->expects($this->at(2))
            ->method('getProcess')
            ->with('sudo service apache2 reload')
            ->willReturn($processThree);

        $processOne->expects($this->once())
            ->method('run');
        $processTwo->expects($this->once())
            ->method('run');
        $processThree->expects($this->once())
            ->method('run');

        $command = new GenerateVHostCommand();
        $command->setContainer($container);
        $command->setGenerator($generator);
        $command->setFileSystem($fileSystem);
        $command->setProcessFactory($processFactory);

        $helpers = $this->getHelpers();
        $helpers['question']->expects($this->once())
            ->method('ask')
            ->willReturn(true);
        $helpers['formatter']->expects($this->once())
            ->method('formatBlock')
            ->willReturn('');

        $command->setHelperSet(new HelperSet($helpers));

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
        $helpers['formatter'] = $formatterHelper;

        return $helpers;
    }
}
