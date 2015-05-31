<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory;

use Eps\VhostGeneratorBundle\Generator\Property\ValidatablePropertyInterface;

/**
 * Class AllowOverrideProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class AllowOverrideProperty implements ValidatablePropertyInterface
{
    const NAME = 'AllowOverride';

    const ALL = 'All';

    const NONE = 'None';

    const AUTH_CONFIG = 'AuthConfig';

    const FILE_INFO = 'FileInfo';

    const INDEXES = 'Indexes';

    const LIMIT = 'Limit';

    const NONFATAL_OVERRIDE = 'Nonfatal=Override';

    const NONFATAL_UNKNOWN = 'Nonfatal=Unknown';

    const NONFATAL_ALL = 'Nonfatal=All';

    /**
     * @var array AllowOverride options
     */
    protected $options = [];

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

        $this->options = array_unique($result);
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
        return implode(' ', $this->options);
    }

    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid()
    {
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

        foreach ($this->options as $option) {
            if (!in_array($option, $acceptableValues)) {
                return false;
            }
        }

        return true;
    }
}
