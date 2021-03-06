<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Node;

use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\AllowOverrideProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\AllowProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\DenyProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\OptionsProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\OrderProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\RequireProperty;
use Eps\VhostGeneratorBundle\Generator\Exception\ValidationException;
use Eps\VhostGeneratorBundle\Generator\Node\NodeInterface;

/**
 * Class DirectoryNode
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Node
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class DirectoryNode implements NodeInterface
{
    use NodeHelperTrait;

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
        if (!($options instanceof OptionsProperty)) {
            $options = new OptionsProperty($options);
        }

        $this->addProperty(OptionsProperty::NAME, $options, $this->properties);
    }

    /**
     * Sets the AllowOverride property
     *
     * @param array|AllowOverrideProperty $options
     * @return self
     */
    public function setAllowOverride($options)
    {
        if (!($options instanceof AllowOverrideProperty)) {
           $options = new AllowOverrideProperty($options);
        }

        $this->addProperty(AllowOverrideProperty::NAME, $options, $this->properties);

        return $this;
    }

    /**
     * Sets the Require property
     *
     * @param string|RequireProperty $requireOptions
     * @return self
     */
    public function setRequire($requireOptions)
    {
        if (!($requireOptions instanceof RequireProperty)) {
            $requireOptions = new RequireProperty($requireOptions);
        }

        $this->addProperty(RequireProperty::NAME, $requireOptions, $this->properties);

        return $this;
    }

    /**
     * Sets the Allow property
     *
     * @param string|AllowProperty $allow
     * @return self
     */
    public function setAllow($allow)
    {
        if (!($allow instanceof AllowProperty)) {
            $allow = new AllowProperty($allow);
        }

        $this->addProperty(AllowProperty::NAME, $allow, $this->properties);

        return $this;
    }

    /**
     * Sets the Deny property
     *
     * @param string|DenyProperty $deny
     * @return self
     */
    public function setDeny($deny)
    {
        if (!($deny instanceof DenyProperty)) {
            $deny = new DenyProperty($deny);
        }

        $this->addProperty(DenyProperty::NAME, $deny, $this->properties);

        return $this;
    }

    /**
     * Sets the Order property
     *
     * @param string|OrderProperty $order
     * @return self
     */
    public function setOrder($order)
    {
        if (!($order instanceof OrderProperty)) {
            $order = new OrderProperty($order);
        }

        $this->addProperty(OrderProperty::NAME, $order, $this->properties);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNodes()
    {
        return [];
    }
}
