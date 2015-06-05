<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory;

use Eps\VhostGeneratorBundle\Generator\Property\PropertyInterface;
use Eps\VhostGeneratorBundle\Generator\Property\StringProperty;

/**
 * Class AllowProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class AllowProperty extends StringProperty
{
    const NAME = 'Allow';

    /**
     * {@inheritdoc}
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
