<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory;

use Eps\VhostGeneratorBundle\Generator\Property\MultipleOptionsProperty;
use Eps\VhostGeneratorBundle\Generator\Property\ValidatablePropertyInterface;

/**
 * Class AllowOverrideProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory
 * @author Jakub Turek <ja@kubaturek.pl>
 * @todo In case when string is input, try to detect correct value from acceptable ones
 */
class AllowOverrideProperty extends MultipleOptionsProperty
{
    const NAME = 'AllowOverride';

    /**
     * Enable all options
     */
    const ALL = 'All';

    /**
     * Disable all options
     */
    const NONE = 'None';

    /**
     * Enable use of the authorization directives
     */
    const AUTH_CONFIG = 'AuthConfig';

    /**
     * Enable use of the directives controlling document types
     */
    const FILE_INFO = 'FileInfo';

    /**
     * Enable use of the directives controlling directory indexing
     */
    const INDEXES = 'Indexes';

    /**
     * Enable use of the directives controlling host access
     */
    const LIMIT = 'Limit';

    /**
     * Treat directives forbidden by AllowOverride as non-fatal
     */
    const NONFATAL_OVERRIDE = 'Nonfatal=Override';

    /**
     * Treats unknown directives as non-fatal
     */
    const NONFATAL_UNKNOWN = 'Nonfatal=Unknown';

    /**
     * Treats "Override" and "Unknown" the above as non-fatal
     */
    const NONFATAL_ALL = 'Nonfatal=All';

    public function __construct(array $options)
    {
        $result = [];
        $includesAll = in_array(self::ALL, $options, true);
        $includesNone = in_array(self::NONE, $options, true);

        foreach ($options as $option) {
            if ($option == self::ALL || $option == self::NONE) {
                if ($includesAll && $includesNone) {
                    $result[] = self::ALL;
                } else {
                    $result[] = $option;
                }
            } elseif (!$includesAll && !$includesNone) {
                $result[] = $option;
            }
        }

        $this->value = array_unique($result);
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
        return implode(' ', $this->value);
    }

    /**
     * Returns the options array
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->value;
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
            AllowOverrideProperty::ALL,
            AllowOverrideProperty::NONE,
            AllowOverrideProperty::AUTH_CONFIG,
            AllowOverrideProperty::FILE_INFO,
            AllowOverrideProperty::INDEXES,
            AllowOverrideProperty::LIMIT,
            AllowOverrideProperty::NONFATAL_ALL,
            AllowOverrideProperty::NONFATAL_UNKNOWN,
            AllowOverrideProperty::NONFATAL_OVERRIDE
        ];

        foreach ($this->value as $option) {
            if (!in_array($option, $acceptableValues)) {
                return false;
            }
        }

        return true;
    }
}
