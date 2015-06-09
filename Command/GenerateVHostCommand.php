<?php

namespace Eps\VhostGeneratorBundle\Command;

use Eps\VhostGeneratorBundle\Generator\GeneratorInterface;
use Eps\VhostGeneratorBundle\Util\SymfonyProcessFactory;
use Sensio\Bundle\GeneratorBundle\Command\Helper\QuestionHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class GenerateVHostCommand
 * @package Eps\VhostGeneratorBundle\Command
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class GenerateVHostCommand extends ContainerAwareCommand
{
    /**
     * @var GeneratorInterface
     */
    private $generator;

    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * @var SymfonyProcessFactory
     */
    private $processFactory;

    public function setGenerator(GeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public function setFileSystem(Filesystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function setProcessFactory(SymfonyProcessFactory $processFactory)
    {
        $this->processFactory = $processFactory;
    }

    protected function configure()
    {
        $this->setName('vhost:generate');
        $this->setDescription("Generate and apply VHost configuration file");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');
        /** @var FormatterHelper $formatterHelper */
        $formatterHelper = $this->getHelper('formatter');

        $question = new ConfirmationQuestion(
            $formatterHelper->formatBlock(
                "Warning: This command uses 'sudo', 'service' and 'a2ensite'. Do you want to continue? (Y/n):",
                'question'
            ),
            true
        );

        if (!$questionHelper->ask($input, $output, $question)) {
            return;
        }

        $vhosts = $this->getContainer()->getParameter('vhost_generator.apache.vhosts');
        $vhostsPath = $this->getContainer()->getParameter('vhost_generator.apache.vhosts_path');
        $outputFile = $this->getContainer()->getParameter('vhost_generator.apache.output_file');

        $output->write("<info>Generating vhost config contents...</info>");
        $configsContent = $this->generator->generate($vhosts);

        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERY_VERBOSE) {
            $output->writeln('');
            $output->writeln('<comment>Following config is going to be applied: </comment>');
            $output->writeln($configsContent);
        }

        $output->writeln('<info>OK</info>');

        $filePath = $this->getTempFileName($configsContent);

        $this->fileSystem->dumpFile($filePath, $configsContent);
        $this->executeShellCommand(
            "sudo cp $filePath $vhostsPath/$outputFile",
            "Copying temporary config to vhosts path...",
            $output
        );
        $this->executeShellCommand(
            "sudo a2ensite $outputFile",
            "Enabling new VHost config...",
            $output
        );
        $this->executeShellCommand(
            "sudo service apache2 reload",
            "Restating services...",
            $output
        );
    }

    /**
     * Returns temporary file name for apache vhost
     *
     * @param $configsContent
     * @return string
     */
    private function getTempFileName($configsContent)
    {
        return sys_get_temp_dir() . '/vhost_' . substr(md5($configsContent), 0, 7);
    }

    /**
     * Executes the command and outputs the status
     *
     * @param $command
     * @param OutputInterface $output
     */
    private function executeShellCommand($command, $comment, OutputInterface $output)
    {
        $output->write("<info>$comment</info>");

        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
            $output->writeln('');
            $output->write("<comment>Executing '$command'... </comment>");
        }

        $command = $this->processFactory->getProcess($command);
        $command->run();

        if (!$command->isSuccessful()) {
            throw new \RuntimeException($command->getErrorOutput());
        }

        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERY_VERBOSE) {
            $output->writeln('');
            $output->write($command->getOutput());
        }

        $output->writeln('<info>OK</info>');
    }
}
