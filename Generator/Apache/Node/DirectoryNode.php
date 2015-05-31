<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Node;

use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\OptionsProperty;
use Eps\VhostGeneratorBundle\Generator\Exception\ValidationException;
use Eps\VhostGeneratorBundle\Generator\Node\NodeInterface;
use Eps\VhostGeneratorBundle\Generator\Property\PropertyInterface;
use Eps\VhostGeneratorBundle\Generator\Property\ValidatablePropertyInterface;

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
     * @var array Directory properties
     */
    protected $properties = [];

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
        return $this->properties;
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

    /**
     * Sets the options of directory
     *
     * @param array|OptionsProperty $options
     */
    public function setOptions($options)
    {
        if (!($options instanceof PropertyInterface)) {
            $options = new OptionsProperty($options);
        }

        $this->addProperty(OptionsProperty::NAME, $options);
    }

    private function addProperty($propertyName, $propertyObject)
    {
        if ($propertyObject instanceof ValidatablePropertyInterface && !$propertyObject->isValid()) {
            throw new ValidationException(
                'Property is invalid',
                "{$propertyObject->getName()}={$propertyObject->getValue()}"
            );
        }

        $this->properties[$propertyName] = $propertyObject;
    }
}
