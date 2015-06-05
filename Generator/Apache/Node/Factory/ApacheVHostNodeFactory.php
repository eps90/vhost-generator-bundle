<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Node\Factory;

use Eps\VhostGeneratorBundle\Generator\Apache\Node\ApacheVHostNode;
use Eps\VhostGeneratorBundle\Generator\Node\Factory\NodeFactoryInterface;

/**
 * Class ApacheVHostNodeFactory
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Node\Factory
 * @author Jakub Turek <ja@kubaturek.pl>
 * @todo Check whether server_name is present
 * @todo Check whether document_root is present
 */
class ApacheVHostNodeFactory implements NodeFactoryInterface
{
    protected $directoryNodeFactory;

    public function __construct(DirectoryNodeFactory $directoryNodeFactory)
    {
        $this->directoryNodeFactory = $directoryNodeFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function createNodes(array $nodesConfiguration)
    {
        $nodes = [];
        foreach ($nodesConfiguration as $nodeConfiguration) {
            $vhostNode = new ApacheVHostNode();

            $ipAddress = '*';
            $port = 80;
            if (isset($nodeConfiguration['ip_address'])) {
                $ipAddress = $nodeConfiguration['ip_address'];
            }

            if (isset($nodeConfiguration['port'])) {
                $port = $nodeConfiguration['port'];
            }

            $vhostNode->setAddress($ipAddress, $port);

            if (isset($nodeConfiguration['server_name'])) {
                $vhostNode->setServerName($nodeConfiguration['server_name']);
            }

            if (isset($nodeConfiguration['server_aliases'])) {
                $vhostNode->setServerAliases($nodeConfiguration['server_aliases']);
            }

            if (isset($nodeConfiguration['document_root'])) {
                $vhostNode->setDocumentRoot($nodeConfiguration['document_root']);
            }

            if (isset($nodeConfiguration['directories'])) {
                $directoryNodes = $this->directoryNodeFactory->createNodes($nodeConfiguration['directories']);
                foreach ($directoryNodes as $directoryNode) {
                    $vhostNode->addDirectoryNode($directoryNode);
                }
            }

            $nodes[] = $vhostNode;
        }

        return $nodes;
    }
}
