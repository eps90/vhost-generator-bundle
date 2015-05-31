<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Node;

use Eps\VhostGeneratorBundle\Generator\Exception\ValidationException;
use Eps\VhostGeneratorBundle\Generator\Node\NodeInterface;

/**
 * Class DirectoryNode
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Node
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class DirectoryNode implements NodeInterface
{
    const DIRECTORY_PATH = 'path';

    /**
     * @var array Directory attributes
     */
    protected $attributes = [];

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Directory';
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function getProperties()
    {
        // TODO: Implement getProperties() method.
    }

    /**
     * Sets the directory path attribute
     *
     * @param string $path
     * @return self
     * @throws ValidationException
     */
    public function setDirectoryPath($path)
    {
        if (!file_exists($path)) {
            throw new ValidationException('Invalid directory path', $path);
        }

        $this->attributes[self::DIRECTORY_PATH] = $path;

        return $this;
    }
}
