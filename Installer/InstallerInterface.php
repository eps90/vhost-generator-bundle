<?php

namespace Eps\VhostGeneratorBundle\Installer;

use Eps\VhostGeneratorBundle\Generator\GeneratorInterface;

/**
 * Interface InstallerInterface
 * @package Eps\VhostGeneratorBundle\Installer
 * @author Jakub Turek <ja@kubaturek.pl>
 */
interface InstallerInterface
{
    /**
     * Applies generated config on system
     *
     * @returns boolean
     */
    public function install();
}
