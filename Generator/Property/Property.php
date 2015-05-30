<?php

namespace Eps\VhostGeneratorBundle\Generator\Property;

/**
 * Class Property
 * @package Eps\VhostGeneratorBundle\Generator\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class Property implements PropertyInterface
{
    protected $name;
    protected $value;

    public function __construct($name, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }
}
