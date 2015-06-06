<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Node\Factory;

use Eps\VhostGeneratorBundle\Generator\Apache\Node\ApacheVHostNode;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\DocumentRootProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerNameProperty;
use Eps\VhostGeneratorBundle\Generator\Exception\MissingPropertyException;
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
            } else {
                throw new MissingPropertyException($vhostNode, ServerNameProperty::NAME);
            }

            if (isset($nodeConfiguration['server_aliases']) && !empty($nodeConfiguration['server_aliases'])) {
                $vhostNode->setServerAliases($nodeConfiguration['server_aliases']);
            }

            if (isset($nodeConfiguration['document_root'])) {
                $vhostNode->setDocumentRoot($nodeConfiguration['document_root']);
            } else {
                throw new MissingPropertyException($vhostNode, DocumentRootProperty::NAME);
            }

            if (isset($nodeConfiguration['error_log'])) {
                $vhostNode->setErrorLog($nodeConfiguration['error_log']);
            }

            if (isset($nodeConfiguration['custom_log'])) {
                $vhostNode->setCustomLog($nodeConfiguration['custom_log']);
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
