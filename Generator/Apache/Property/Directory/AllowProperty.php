<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory;

use Eps\VhostGeneratorBundle\Generator\Property\PropertyInterface;

/**
 * Class AllowProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory
 * @author Jakub Turek <ja@kubaturek.pl>
 * @todo Let AllowProperty implement ValidatabePropertyInterface
 * @todo Allow complex expressions
 */
class AllowProperty implements PropertyInterface
{
    const NAME = 'Allow';

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
        return 'from ' . $this->value;
    }
}
