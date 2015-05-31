<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Node;

use Eps\VhostGeneratorBundle\Generator\Exception\ValidationException;
use Eps\VhostGeneratorBundle\Generator\Property\PropertyInterface;
use Eps\VhostGeneratorBundle\Generator\Property\ValidatablePropertyInterface;

/**
 * Class NodeHelperTrait
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Node
 * @author Jakub Turek <ja@kubaturek.pl>
 */
trait NodeHelperTrait
{
    /**
     * Validate and set property to $properties
     *
     * @param string $propertyName
     * @param PropertyInterface $propertyObject
     * @param array $properties
     * @throws ValidationException
     */
    protected function addProperty($propertyName, PropertyInterface $propertyObject, array &$properties)
    {
        if ($propertyObject instanceof ValidatablePropertyInterface && !$propertyObject->isValid()) {
            throw new ValidationException(
                'Property is invalid',
                "{$propertyObject->getName()}={$propertyObject->getValue()}"
            );
        }

        $properties[$propertyName] = $propertyObject;
    }
}
