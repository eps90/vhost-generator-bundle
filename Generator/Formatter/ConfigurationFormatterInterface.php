<?php

namespace Eps\VhostGeneratorBundle\Generator\Formatter;

use Eps\VhostGeneratorBundle\Generator\Node\NodeInterface;


/**
 * Interface ConfigurationFormatterInterface
 * @package Eps\VhostGeneratorBundle\Generator
 * @author Jakub Turek <ja@kubaturek.pl>
 */
interface ConfigurationFormatterInterface
{
    /**
     * Returns string with rendered configuration file
     *
     * @param NodeInterface[] $nodes
     * @return mixed
     */
    public function createConfig(array $nodes);
}
