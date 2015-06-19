<?php

namespace Eps\VhostGeneratorBundle\Installer;

/**
 * Interface InstallerFactoryInterface
 * @package Eps\VhostGeneratorBundle\Installer
 * @author Jakub Turek <ja@kubaturek.pl>
 */
interface InstallerFactoryInterface
{
    /**
     * Returns proper installer instance
     *
     * @return InstallerInterface
     */
    public static function getInstaller();

    /**
     * Adds an installer for given operating system
     *
     * @param $operatingSystem
     * @param InstallerInterface $installer
     * @return self
     */
    public function addInstaller($operatingSystem, InstallerInterface $installer);
}
