<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Node\Factory;

use Eps\VhostGeneratorBundle\Generator\Apache\Node\DirectoryNode;
use Eps\VhostGeneratorBundle\Generator\Node\Factory\NodeFactoryInterface;
use Eps\VhostGeneratorBundle\Generator\Node\NodeInterface;

/**
 * Class DirectoryNodeProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Node\Factory
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class DirectoryNodeFactory implements NodeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNode(array $nodeConfiguration)
    {
        $directoryNode = new DirectoryNode();
        $directoryNode->setDirectoryPath($nodeConfiguration['path']);
        $directoryNode->setAllow($nodeConfiguration['allow']);
        $directoryNode->setAllowOverride($nodeConfiguration['allow_override']);
        $directoryNode->setOptions($nodeConfiguration['options']);
        $directoryNode->setRequire($nodeConfiguration['require']);

        return $directoryNode;
    }
}
