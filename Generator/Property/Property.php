<?php

namespace Eps\VhostGeneratorBundle\Generator\Property;

/**
 * Class Property
 * @package Eps\VhostGeneratorBundle\Generator\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 */
abstract class Property implements PropertyInterface
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
