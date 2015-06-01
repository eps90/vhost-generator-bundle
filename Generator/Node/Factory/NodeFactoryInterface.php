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
     * Creates a node by given configuration options
     *
     * @param array $nodeConfiguration
     * @return NodeInterface
     */
    public function createNode(array $nodeConfiguration);
}
