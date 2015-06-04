<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost;

use Eps\VhostGeneratorBundle\Generator\Property\StringProperty;

/**
 * Class DocumentRootProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class DocumentRootProperty extends StringProperty
{
    const NAME = 'DocumentRoot';

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
     * Determines whether property value is valid
     *
     * @return mixed
     */
    public function isValid()
    {
        return parent::isValid() && file_exists($this->value);
    }
}
