<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Formatter;

use Eps\VhostGeneratorBundle\Generator\Formatter\ConfigurationFormatterInterface;
use Eps\VhostGeneratorBundle\Generator\Node\NodeInterface;

/**
 * Class ApacheVHostFormatter
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Formatter
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ApacheVHostFormatter implements ConfigurationFormatterInterface
{
    /**
     * Returns string with rendered configuration file
     *
     * @param NodeInterface[] $nodes
     * @return mixed
     */
    public function createConfig(array $nodes)
    {
        $result = '';

        foreach ($nodes as $node) {
            $result .= $this->renderNode($node);
        }

        return $result;
    }

    /**
     * Render single node
     *
     * @param NodeInterface $node
     * @param int $indentationCount
     * @return string
     */
    private function renderNode(NodeInterface $node, $indentationCount = 0)
    {
        $result = '';
        $indentation = str_repeat(' ', $indentationCount);
        $innerIndentationCount = $indentationCount + 4;
        $innerIndentation = str_repeat(' ', $innerIndentationCount);

        $nodeName = $node->getName();
        $nodeAttributes = implode(' ', $node->getAttributes());
        $nodeProperties = $node->getProperties();
        $nodeNodes = $node->getNodes();

        $result .= "$indentation<$nodeName $nodeAttributes>" . PHP_EOL;
        foreach ($nodeProperties as $property) {
            $result .= $innerIndentation . $property->getName() . ' ' . $property->getValue() . PHP_EOL;
        }

        if (!empty($nodeNodes)) {
            foreach ($nodeNodes as $innerNode) {
                $result .= PHP_EOL;
                $result .= $this->renderNode($innerNode, $innerIndentationCount);
            }
        }

        $result .= $indentation . "</$nodeName>" . PHP_EOL;

        return $result;
    }
}
