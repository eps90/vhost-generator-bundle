<?php

namespace Eps\VhostGeneratorBundle\Generator;

/**
 * Interface GeneratorInterface
 * @package Eps\VhostGeneratorBundle\Generator
 * @author Jakub Turek <ja@kubaturek.pl>
 */
interface GeneratorInterface 
{
    /**
     * Generates config as string for given configuration value
     *
     * @param array $config
     * @return string
     */
    public function generate(array $config);
}
