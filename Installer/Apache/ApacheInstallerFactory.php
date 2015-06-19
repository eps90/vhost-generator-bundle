<?php

namespace Eps\VhostGeneratorBundle\Installer\Apache;

use Eps\VhostGeneratorBundle\Installer\InstallerFactoryInterface;
use Eps\VhostGeneratorBundle\Installer\InstallerInterface;
use Eps\VhostGeneratorBundle\Util\OsDetector;

/**
 * Class ApacheInstallerFactory
 * @package Eps\VhostGeneratorBundle\Installer\Apache
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ApacheInstallerFactory implements InstallerFactoryInterface
{
    /**
     * @var OsDetector
     */
    private $osDetector;

    /**
     * @var InstallerInterface[]
     */
    private $installers;

    public function __construct(OsDetector $osDetector)
    {
        $this->osDetector = $osDetector;
    }

    /**
     * {@inheritdoc}
     */
    public function getInstaller()
    {
        $operatingSystem = strtolower($this->osDetector->detect());
        if (!isset($this->installers[$operatingSystem])) {
            throw new \Exception("Installer for '$operatingSystem' has not been found");
        }

        return $this->installers[$operatingSystem];
    }

    /**
     * {@inheritdoc}
     */
    public function addInstaller($operatingSystem, InstallerInterface $installer)
    {
        $this->installers[$operatingSystem] = $installer;

        return $this;
    }
}
