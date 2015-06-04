<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost;

use Eps\VhostGeneratorBundle\Generator\Property\StringProperty;
use Eps\VhostGeneratorBundle\Generator\Property\ValidatablePropertyInterface;

/**
 * Class ServerNameProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 * @todo Allow to add array of values
 */
class ServerNameProperty extends StringProperty
{
    const NAME = 'ServerName';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }
}
