<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property;

/**
 * Class ServerAliasProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ServerAliasProperty extends ServerNameProperty
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
