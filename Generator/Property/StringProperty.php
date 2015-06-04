<?php

namespace Eps\VhostGeneratorBundle\Generator\Property;

/**
 * Class StringProperty
 * @package Eps\VhostGeneratorBundle\Generator\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 */
abstract class StringProperty extends AbstractProperty implements ValidatablePropertyInterface
{
    /**
     * @{inheritdoc}
     */
    public function isValid()
    {
        return is_string($this->value) && !empty($this->value);
    }
}
