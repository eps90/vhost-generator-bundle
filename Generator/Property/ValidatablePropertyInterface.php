<?php

namespace Eps\VhostGeneratorBundle\Generator\Property;

/**
 * Interface ValidatablePropertyInterface
 * @package Eps\VhostGeneratorBundle\Generator\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 */
interface ValidatablePropertyInterface
{
    /**
     * Determines whether property value is valid
     *
     * @return mixed
     */
    public function isValid();
}
