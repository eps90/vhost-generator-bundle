<?php

namespace Eps\VhostGeneratorBundle\Generator\Node;

use Eps\VhostGeneratorBundle\Generator\Property\PropertyInterface;

/**
 * Interface NodeInterface
 * @package Eps\VhostGeneratorBundle\Generator\Node
 * @author Jakub Turek <ja@kubaturek.pl>
 */
interface NodeInterface
{
    /**
     * Returns the name of node.
     * This name is used to generate config node.
     * E.g.: If you put 'ABC' here, it will be rendered as <ABC></ABC> for Apache VHost node
     *
     * @return string
     */
    public function getName();

    /**
     * Returns configuration node specific attributes.
     * These attributes are going to be rendered as configuration node parameters.
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Returns the key-value array with node configuration.
     *
     * @return PropertyInterface[]
     */
    public function getProperties();

    /**
     * Returns nested nodes that belong to the node
     *
     * @return NodeInterface[]
     */
    public function getNodes();
}
