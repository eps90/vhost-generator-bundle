<?php

namespace Eps\VhostGeneratorBundle\Util;

use Symfony\Component\Process\Process;

/**
 * Class SymfonyProcessFactory
 * @package Eps\VhostGeneratorBundle\Util
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class SymfonyProcessFactory 
{
    /**
     * Generates a Process object with given command
     *
     * @param string $command
     * @return Process
     */
    public function getProcess($command)
    {
        return new Process($command);
    }
}
