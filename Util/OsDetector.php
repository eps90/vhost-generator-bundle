<?php

namespace Eps\VhostGeneratorBundle\Util;

/**
 * Class OsDetector
 * @package Eps\VhostGeneratorBundle\Util
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class OsDetector 
{
    /**
     * @var OperatingSystem
     */
    private $os;
    private $osMapping = [
        'linux' => OperatingSystem::LINUX
    ];


    public function __construct(OperatingSystem $os)
    {
        $this->os = $os;
    }

    public function detect()
    {
        $osName = strtolower($this->os->getName());
        if (isset($this->osMapping[$osName])) {
            return $this->osMapping[$osName];
        }

        return null;
    }
}
