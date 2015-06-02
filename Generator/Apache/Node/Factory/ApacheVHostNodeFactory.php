<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Node\Factory;

use Eps\VhostGeneratorBundle\Generator\Apache\Node\ApacheVHostNode;
use Eps\VhostGeneratorBundle\Generator\Node\Factory\NodeFactoryInterface;

/**
 * Class ApacheVHostNodeFactory
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Node\Factory
 * @author Jakub Turek <ja@kubaturek.pl>
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
    public function createNode(array $nodeConfiguration)
    {
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

        if (isset($nodeConfiguration['server_alias'])) {
            $vhostNode->setServerAlias($nodeConfiguration['server_alias']);
        }

        if (isset($nodeConfiguration['document_root'])) {
            $vhostNode->setDocumentRoot($nodeConfiguration['document_root']);
        }

        if (isset($nodeConfiguration['directories'])) {
            foreach ($nodeConfiguration['directories'] as $directoryConfig) {
                $vhostNode->addDirectoryNode($this->directoryNodeFactory->createNode($directoryConfig));
            }
        }

        return $vhostNode;
    }
}
