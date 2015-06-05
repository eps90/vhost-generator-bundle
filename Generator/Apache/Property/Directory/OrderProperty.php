<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory;

use Eps\VhostGeneratorBundle\Generator\Property\StringProperty;

class OrderProperty extends StringProperty
{
    const NAME = 'Order';

    /**
     * First evaluate Allow expressions, then Deny expressions
     */
    const ALLOW_DENY = 'Allow,Deny';

    /**
     * First evaluate Deny expressions, then Allow expressions
     */
    const DENY_ALLOW = 'Deny,Allow';

    public function __construct($value)
    {
        $this->value = $this->detectValue($value);
    }

    private function detectValue($value)
    {
        if (!is_string($value)) {
            return $value;
        }

        $availableValues = [
            self::ALLOW_DENY,
            self::DENY_ALLOW
        ];

        $value = preg_replace('/[\s\-_,\.]/', '', $value);

        foreach ($availableValues as $availableValue) {
            $cleanValue = preg_replace('/[\s\-_,\.]/', '', $availableValue);
            if (strtolower($value) == strtolower($cleanValue)) {
                $value = $availableValue;
                break;
            }
        }

        return $value;
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
    public function isValid()
    {
        if (!parent::isValid()) {
            return false;
        }

        $acceptableValues = [
            self::ALLOW_DENY,
            self::DENY_ALLOW
        ];

        return in_array($this->value, $acceptableValues);
    }
}
