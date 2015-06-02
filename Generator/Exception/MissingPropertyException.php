<?php

namespace Eps\VhostGeneratorBundle\Generator\Exception;

use Eps\VhostGeneratorBundle\Generator\Node\NodeInterface;

/**
 * Class MissingPropertyException
 * @package Eps\VhostGeneratorBundle\Generator\Exception
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class MissingPropertyException extends \Exception
{
    public function __construct(NodeInterface $node, $propertyName, $message = '', $code = 0, \Exception $previous = null)
    {
        $message = "Missing '$propertyName' in node {$node->getName()}";
        parent::__construct($message, $code, $previous);
    }
}
