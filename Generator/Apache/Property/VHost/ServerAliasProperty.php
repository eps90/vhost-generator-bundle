<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost;

use Eps\VhostGeneratorBundle\Generator\Property\StringProperty;

/**
 * Class ServerAliasProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ServerAliasProperty extends StringProperty
{
    const NAME = 'ServerAlias';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }
}
