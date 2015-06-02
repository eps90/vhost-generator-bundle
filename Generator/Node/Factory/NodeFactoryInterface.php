<?php

namespace Eps\VhostGeneratorBundle\Generator\Node\Factory;

use Eps\VhostGeneratorBundle\Generator\Node\NodeInterface;

/**
 * Interface NodeFactoryInterface
 * @package Eps\VhostGeneratorBundle\Generator\Node\Factory
 * @author Jakub Turek <ja@kubaturek.pl>
 */
interface NodeFactoryInterface 
{
    /**
     * Creates nodes by given configuration options
     *
     * @param array $nodesConfiguration
     * @return NodeInterface[]
     */
    public function createNodes(array $nodesConfiguration);
}
