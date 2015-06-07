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
 * @todo Add output messages
 * @todo Check whether commands ran successfully
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
                "Warning: This command uses 'sudo', 'service' and 'a2ensite'. Do you want to continue? (Y/n): ",
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

        $configsContent = $this->generator->generate($vhosts);
        $filePath = $this->getTempFileName($configsContent);

        $this->fileSystem->dumpFile($filePath, $configsContent);
        $copyCommand = $this->processFactory->getProcess("sudo cp $filePath $vhostsPath/$outputFile");
        $enableCommand = $this->processFactory->getProcess("sudo a2ensite $outputFile");
        $reloadCommand = $this->processFactory->getProcess("sudo service apache2 reload");

        $copyCommand->run();
        $enableCommand->run();
        $reloadCommand->run();
    }

    private function getTempFileName($configsContent)
    {
        return sys_get_temp_dir() . '/vhost_' . substr(md5($configsContent), 0, 7);
    }
}
