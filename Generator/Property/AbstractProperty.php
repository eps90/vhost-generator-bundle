<?php

namespace Eps\VhostGeneratorBundle\Generator\Property;

/**
 * Class AbstractProperty
 * @package Eps\VhostGeneratorBundle\Generator\AbstractProperty
 * @author Jakub Turek <ja@kubaturek.pl>
 */
abstract class AbstractProperty implements PropertyInterface
{
    /**
     * @var mixed Property value
     */
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }
}
