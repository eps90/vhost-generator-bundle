<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory;

use Eps\VhostGeneratorBundle\Generator\Property\AbstractProperty;
use Eps\VhostGeneratorBundle\Generator\Property\PropertyInterface;

/**
 * Class RequireProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory
 * @author Jakub Turek <ja@kubaturek.pl>
 * @todo Let RequireProperty implement ValidatablePropertyInterface
 * @todo Extend RequireProperty with advanced values such as ip, users, etc.
 */
class RequireProperty extends AbstractProperty
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
