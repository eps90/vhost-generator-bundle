<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory;

use Eps\VhostGeneratorBundle\Generator\Property\StringProperty;

/**
 * Class DenyProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class DenyProperty extends StringProperty
{
    const NAME = 'Deny';

    /**
     * Returns name of the property.
     *
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return 'from ' . $this->value;
    }
}
