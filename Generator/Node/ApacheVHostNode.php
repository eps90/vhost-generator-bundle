<?php

namespace Eps\VhostGeneratorBundle\Generator\Node;

/**
 * Class ApacheVHostNode
 * @package Eps\VhostGeneratorBundle\Generator\Node
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ApacheVHostNode implements NodeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'VirtualHost';
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return [];
    }
}
