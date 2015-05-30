<?php

namespace Eps\VhostGeneratorBundle\Generator\Property;

/**
 * Interface PropertyInterface
 * @package Eps\VhostGeneratorBundle\Generator\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 */
interface PropertyInterface 
{
    /**
     * Returns name of the property.
     *
     * @return string
     */
    public function getName();

    /**
     * Returns the scalar value of the property.
     *
     * @return mixed
     */
    public function getValue();
}
