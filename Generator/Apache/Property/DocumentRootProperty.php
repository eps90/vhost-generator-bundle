<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property;

use Eps\VhostGeneratorBundle\Generator\Exception\ValidationException;
use Eps\VhostGeneratorBundle\Generator\Property\ValidatablePropertyInterface;

/**
 * Class DocumentRootProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class DocumentRootProperty implements ValidatablePropertyInterface
{
    const NAME = 'DocumentRoot';

    protected $value;

    /**
     * @param string $documentRoot
     */
    public function __construct($documentRoot)
    {
        $this->value = $documentRoot;
    }

    /**
     * Returns name of the property.
     *
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * {@inheritDoc}
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Determines whether property value is valid
     *
     * @return mixed
     */
    public function isValid()
    {
        return is_string($this->value) && file_exists($this->value);
    }
}
