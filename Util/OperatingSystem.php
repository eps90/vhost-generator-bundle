<?php

namespace Eps\VhostGeneratorBundle\Util;

/**
 * Class OperatingSystem
 * @package Eps\VhostGeneratorBundle\Util
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class OperatingSystem 
{
    const LINUX = 'Linux';
    const UNKNOWN = 'Unknown';

    /**
     * Returns PHP_OS constant contents
     *
     * @return string
     */
    public function getName()
    {
        return PHP_OS;
    }
}
