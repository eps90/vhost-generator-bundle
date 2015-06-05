<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost;

use Eps\VhostGeneratorBundle\Generator\Property\MultipleOptionsProperty;

/**
 * Class ServerAliasProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ServerAliasProperty extends MultipleOptionsProperty
{
    const NAME = 'ServerAlias';

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
        return implode(' ', $this->value);
    }
}
