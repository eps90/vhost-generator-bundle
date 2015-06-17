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

        $containerParams = [
            [
                'name' => 'vhost_generator.apache.vhosts',
                'value' => $sampleConfig
            ],
            [
                'name' => 'vhost_generator.apache.vhosts_path',
                'value' => $vhostsPath,
            ],
            [
                'name' => 'vhost_generator.apache.output_file',
                'value' => $outputFile
            ]
        ];

        $this->mockContainerParameters($container, $containerParams);

        $generator = $this->getMock('Eps\VhostGeneratorBundle\Generator\GeneratorInterface');
        $generator->expects($this->once())
            ->method('generate')
            ->with($sampleConfig)
            ->willReturn($generatedConfig);

        $fileSystem = $this->getMock('Symfony\Component\Filesystem\Filesystem');
        $fileSystem->expects($this->once())
            ->method('dumpFile')
            ->with($tmpFilePath, $generatedConfig);

        $processFactory = $this->getMock('Eps\VhostGeneratorBundle\Util\SymfonyProcessFactory');
        $this->expectProcess($processFactory, "sudo cp $tmpFilePath {$vhostsPath}/$outputFile", true);
        $this->expectProcess($processFactory, "sudo a2ensite $outputFile", true);
        $this->expectProcess($processFactory, 'sudo service apache2 reload', true);

        $helpers = $this->getHelpers();

        $command = new GenerateVHostCommand();
        $command->setContainer($container);
        $command->setGenerator($generator);
        $command->setFileSystem($fileSystem);
        $command->setProcessFactory($processFactory);
        $command->setHelperSet(new HelperSet($helpers));

        $input = $this->getMock('Symfony\Component\Console\Input\InputInterface');
        $output = $this->getMock('Symfony\Component\Console\Output\OutputInterface');

        $command->run($input, $output);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function itShouldThrowIfOneOfCommandHasFailed()
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
        $containerParams = [
            [
                'name' => 'vhost_generator.apache.vhosts',
                'value' => $sampleConfig
            ],
            [
                'name' => 'vhost_generator.apache.vhosts_path',
                'value' => $vhostsPath,
            ],
            [
                'name' => 'vhost_generator.apache.output_file',
                'value' => $outputFile
            ]
        ];

        $this->mockContainerParameters($container, $containerParams);

        $generator = $this->getMock('Eps\VhostGeneratorBundle\Generator\GeneratorInterface');
        $generator->expects($this->once())
            ->method('generate')
            ->with($sampleConfig)
            ->willReturn($generatedConfig);

        $fileSystem = $this->getMock('Symfony\Component\Filesystem\Filesystem');
        $fileSystem->expects($this->once())
            ->method('dumpFile')
            ->with($tmpFilePath, $generatedConfig);

        $processFactory = $this->getMock('Eps\VhostGeneratorBundle\Util\SymfonyProcessFactory');
        $this->expectProcess($processFactory, "sudo cp $tmpFilePath {$vhostsPath}/$outputFile", false);

        $helpers = $this->getHelpers();

        $command = new GenerateVHostCommand();
        $command->setContainer($container);
        $command->setGenerator($generator);
        $command->setFileSystem($fileSystem);
        $command->setProcessFactory($processFactory);
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
        $questionHelper->expects($this->once())
            ->method('ask')
            ->willReturn(true);
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

    private function mockContainerParameters(\PHPUnit_Framework_MockObject_MockObject $container, array $containerParams)
    {
        for ($i = 0; $i < count($containerParams); $i++) {
            $container->expects($this->at($i))
                ->method('getParameter')
                ->with($containerParams[$i]['name'])
                ->willReturn($containerParams[$i]['value']);
        }
    }
}
