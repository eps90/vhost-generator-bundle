<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory;

use Eps\VhostGeneratorBundle\Generator\Property\StringProperty;

/**
 * Class RequireProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory
 * @author Jakub Turek <ja@kubaturek.pl>
 * @todo Extend RequireProperty with advanced values such as ip, users, etc.
 */
class RequireProperty extends StringProperty
{
    const NAME = 'Require';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }
}
