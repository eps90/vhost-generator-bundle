<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Node\Factory;

use Eps\VhostGeneratorBundle\Generator\Apache\Node\DirectoryNode;
use Eps\VhostGeneratorBundle\Generator\Exception\MissingPropertyException;
use Eps\VhostGeneratorBundle\Generator\Node\Factory\NodeFactoryInterface;

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
    public function createNodes(array $nodesConfiguration)
    {
        $nodes = [];
        foreach ($nodesConfiguration as $nodeConfiguration) {
            $directoryNode = new DirectoryNode();

            if (!isset($nodeConfiguration['path'])) {
                throw new MissingPropertyException($directoryNode, DirectoryNode::DIRECTORY_PATH);
            }

            $directoryNode->setDirectoryPath($nodeConfiguration['path']);

            if (isset($nodeConfiguration['allow'])) {
                $directoryNode->setAllow($nodeConfiguration['allow']);
            }

            if (isset($nodeConfiguration['deny'])) {
                $directoryNode->setDeny($nodeConfiguration['deny']);
            }

            if (isset($nodeConfiguration['allow_override'])) {
                $directoryNode->setAllowOverride($nodeConfiguration['allow_override']);
            }

            if (isset($nodeConfiguration['options'])) {
                $directoryNode->setOptions($nodeConfiguration['options']);
            }

            if (isset($nodeConfiguration['require'])) {
                $directoryNode->setRequire($nodeConfiguration['require']);
            }

            $nodes[] = $directoryNode;
        }

        return $nodes;
    }
}
