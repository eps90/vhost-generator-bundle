<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory;

use Eps\VhostGeneratorBundle\Generator\Property\PropertyInterface;

/**
 * Class RequireProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory
 * @author Jakub Turek <ja@kubaturek.pl>
 * @todo Let RequireProperty implement ValidatablePropertyInterface
 * @todo Extend RequireProperty with advanced values such as ip, users, etc.
 */
class RequireProperty implements PropertyInterface
{
    const NAME = 'Require';

    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

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
        return $this->value;
    }
}
