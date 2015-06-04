<?php

namespace Eps\VhostGeneratorBundle\Generator\Property;

/**
 * Class MultipleOptionsProperty
 * @package Eps\VhostGeneratorBundle\Generator\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 */
abstract class MultipleOptionsProperty extends AbstractProperty implements ValidatablePropertyInterface
{
    public function __construct(array $values)
    {
        $this->value = $values;
    }

    public function isValid()
    {
        if (!is_array($this->value) || (is_array($this->value) && empty($this->value))) {
            return false;
        } else {
            foreach ($this->value as $value) {
                if (empty($value)) {
                    return false;
                }
            }
        }

        return true;
    }
}
