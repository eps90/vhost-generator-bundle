<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost;

use Eps\VhostGeneratorBundle\Generator\Property\StringProperty;

/**
 * Class CustomLogProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class CustomLogProperty extends StringProperty
{
    const NAME = 'CustomLog';

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
        return $this->value . ' combined';
    }
}
