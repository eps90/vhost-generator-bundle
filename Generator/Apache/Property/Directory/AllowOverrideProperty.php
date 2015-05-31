<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory;

use Eps\VhostGeneratorBundle\Generator\Property\ValidatablePropertyInterface;

/**
 * Class AllowOverrideProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class AllowOverrideProperty implements ValidatablePropertyInterface
{
    const NAME = 'AllowOverride';

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
        // TODO: Implement getValue() method.
    }

    /**
     * {@inheritdoc}
     */
    public function isValid()
    {
        // TODO: Implement isValid() method.
    }
}
