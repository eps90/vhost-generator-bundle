<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property;

use Eps\VhostGeneratorBundle\Generator\Property\ValidatablePropertyInterface;

class ServerNameProperty implements ValidatablePropertyInterface
{
    const NAME = 'ServerName';

    protected $value;

    public function __construct($serverName)
    {
        $this->value = $serverName;
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

    /**
     * {@inheritdoc}
     */
    public function isValid()
    {
        return is_string($this->value) && !empty($this->value);
    }
}
