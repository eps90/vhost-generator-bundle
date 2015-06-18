<?php

namespace Eps\VhostGeneratorBundle\Installer\Apache;

use Eps\VhostGeneratorBundle\Generator\GeneratorInterface;
use Eps\VhostGeneratorBundle\Installer\InstallerInterface;

/**
 * Interface ApacheInstallerInterface
 * @package Eps\VhostGeneratorBundle\Installer\Apache
 * @author Jakub Turek <ja@kubaturek.pl>
 */
interface ApacheInstallerInterface extends InstallerInterface
{
    /**
     * Sets the path, where VHosts are
     *
     * @param string $vhostsPath
     * @return self
     */
    public function setVHostsPath($vhostsPath);

    /**
     * Sets the output file name for generated config
     *
     * @param string $outputFile
     * @return self
     */
    public function setOutputFile($outputFile);

    /**
     * Sets configuration of VHosts to apply
     *
     * @param array $vhosts
     * @return mixed
     */
    public function setVHosts(array $vhosts);

    /**
     * Sets the configuration generator for this installer
     *
     * @param GeneratorInterface $generator
     * @return mixed
     */
    public function setGenerator(GeneratorInterface $generator);
}
