<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Node;

use Eps\VhostGeneratorBundle\Generator\Node\NodeInterface;

/**
 * Class ApacheVHostNode
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Node
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
