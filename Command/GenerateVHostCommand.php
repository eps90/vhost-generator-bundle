<?php

namespace Eps\VhostGeneratorBundle\Command;

use Eps\VhostGeneratorBundle\Installer\InstallerInterface;
use Sensio\Bundle\GeneratorBundle\Command\Helper\QuestionHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Class GenerateVHostCommand
 * @package Eps\VhostGeneratorBundle\Command
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class GenerateVHostCommand extends ContainerAwareCommand
{
    /**
     * @var InstallerInterface
     */
    private $installer;

    public function setInstaller(InstallerInterface $installer)
    {
        $this->installer = $installer;
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

        $this->installer->install();
    }
}
