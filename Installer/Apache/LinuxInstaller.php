<?php

namespace Eps\VhostGeneratorBundle\Installer\Apache;

use Eps\VhostGeneratorBundle\Generator\GeneratorInterface;
use Eps\VhostGeneratorBundle\Installer\InstallerInterface;
use Eps\VhostGeneratorBundle\Util\SymfonyProcessFactory;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class LinuxInstaller
 * @package Eps\VhostGeneratorBundle\Installer\Apache
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class LinuxInstaller implements InstallerInterface
{
    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * @var string
     */
    private $vhostsPath;

    /**
     * @var string
     */
    private $outputFile;

    /**
     * @var array
     */
    private $vhosts;

    /**
     * @var GeneratorInterface
     */
    private $generator;

    public function __construct(Filesystem $filesystem, SymfonyProcessFactory $processFactory)
    {
        $this->fileSystem = $filesystem;
        $this->processFactory = $processFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function setVHostsPath($vhostsPath)
    {
        $this->vhostsPath = $vhostsPath;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setOutputFile($outputFile)
    {
        $this->outputFile = $outputFile;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setVHosts(array $vhosts)
    {
        $this->vhosts = $vhosts;
    }

    /**
     * {@inheritdoc}
     */
    public function setGenerator(GeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    /**
     * {@inheritdoc}
     */
    public function install()
    {
        $generatedConfig = $this->generator->generate($this->vhosts);
        $tmpFilePath = $this->getTempFilePath($generatedConfig);

        $this->fileSystem->dumpFile($tmpFilePath, $generatedConfig);

        $this->executeShellCommand("sudo cp $tmpFilePath $this->vhostsPath/$this->outputFile");
        $this->executeShellCommand("sudo a2ensite $this->outputFile");
        $this->executeShellCommand("sudo service apache2 reload");
    }

    /**
     * Returns temporary file name for apache vhost
     *
     * @param $configsContent
     * @return string
     */
    private function getTempFilePath($configsContent)
    {
        return sys_get_temp_dir() . '/vhost_' . substr(md5($configsContent), 0, 7);
    }

    /**
     * Executes the command and outputs the status
     *
     * @param string $command
     */
    private function executeShellCommand($command)
    {
        $command = $this->processFactory->getProcess($command);
        $command->run();

        if (!$command->isSuccessful()) {
            throw new \RuntimeException($command->getErrorOutput());
        }
    }
}
