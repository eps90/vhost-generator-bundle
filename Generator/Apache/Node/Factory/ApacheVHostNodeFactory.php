<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Node\Factory;

use Eps\VhostGeneratorBundle\Generator\Apache\Node\ApacheVHostNode;
use Eps\VhostGeneratorBundle\Generator\Node\Factory\NodeFactoryInterface;
use Eps\VhostGeneratorBundle\Generator\Node\NodeInterface;

/**
 * Class ApacheVHostNodeFactory
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Node\Factory
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ApacheVHostNodeFactory implements NodeFactoryInterface
{
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

        $serverName = $nodeConfiguration['server_name'];
        $serverAlias = $nodeConfiguration['server_alias'];
        $documentRoot = $nodeConfiguration['document_root'];

        $vhostNode->setAddress($ipAddress, $port);
        $vhostNode->setServerName($serverName);
        $vhostNode->setServerAlias($serverAlias);
        $vhostNode->setDocumentRoot($documentRoot);

        return $vhostNode;
    }
}
