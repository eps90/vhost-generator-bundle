<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost;

use Eps\VhostGeneratorBundle\Generator\Property\StringProperty;

/**
 * Class ErrorLogProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ErrorLogProperty extends StringProperty
{
    const NAME = 'ErrorLog';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }
}
