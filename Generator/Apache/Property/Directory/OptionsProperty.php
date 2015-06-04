<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory;

use Eps\VhostGeneratorBundle\Generator\Property\MultipleOptionsProperty;
use Eps\VhostGeneratorBundle\Generator\Property\ValidatablePropertyInterface;

/**
 * Class OptionsProperty
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory
 * @author Jakub Turek <ja@kubaturek.pl>
 * @todo In case when string is input, try to detect correct value from acceptable ones
 */
class OptionsProperty extends MultipleOptionsProperty
{
    const NAME = 'Options';

    /**
     * Enable all options
     */
    const ALL = 'All';

    /**
     * Disable all options
     */
    const NONE = 'None';

    /**
     * Enable execution of CGI scripts
     */
    const EXEC_GGI = 'ExecCGI';

    /**
     * Enable following symbolic links
     */
    const FOLLOW_SYM_LINKS = 'FollowSymLinks';

    /**
     * Enable server-side includes
     */
    const INCLUDES = 'Includes';

    /**
     * Enable server-side includes but disable the exec cmd and exec cgi
     */
    const INCLUDES_NO_EXEC = 'IncludesNOEXEC';

    /**
     * Enable indexes
     */
    const INDEXES = 'Indexes';

    /**
     * Enable content negotiated "MultiViews"
     */
    const MULTI_VIEWS = 'MultiViews';

    /**
     * Enable SymLinksIfOwnerMatch
     */
    const SYM_LINKS_IF_OWNER_MATCH = 'SymLinksIfOwnerMatch';

    /**
     * Constructor.
     * Sets the options. Input array should accept option name as key and boolean as value.
     * Value in array determines whether the option will be enabled or not.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $result = [];
        $includesAll = in_array(self::ALL, $options, true) || in_array(self::ALL, array_keys($options), true);
        $includesNone = in_array(self::NONE, $options, true) || in_array(self::NONE, array_keys($options), true);

        foreach ($options as $optionKey => $optionValue) {
            $key = $optionKey;
            $value = $optionValue;
            if (!is_string($optionKey)) {
                $key = $optionValue;
                $value = true;
            }

            if ($key == self::ALL || $key == self::NONE) {
                if ($includesAll && $includesNone) {
                    $result[self::ALL] = true;
                } else {
                    $result[$key] = $value;
                }
            } elseif (
                ($key == self::MULTI_VIEWS && $includesAll)
                || (!$includesAll && !$includesNone)
            ) {
                $result[$key] = $value;
            }
        }

        $this->value = $result;
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
        $result = [];

        if (array_fill(0, count($this->value), true) == array_values($this->value)) {
            $result = array_keys($this->value);
        } else {
            foreach ($this->value as $optionName => $enabled) {
                $result[] = ($enabled ? '+' : '-') . $optionName;
            }
        }

        return implode(' ', $result);
    }

    /**
     * Returns array of options
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
            OptionsProperty::ALL,
            OptionsProperty::NONE,
            OptionsProperty::EXEC_GGI,
            OptionsProperty::FOLLOW_SYM_LINKS,
            OptionsProperty::INCLUDES,
            OptionsProperty::INCLUDES_NO_EXEC,
            OptionsProperty::INDEXES,
            OptionsProperty::MULTI_VIEWS,
            OptionsProperty::SYM_LINKS_IF_OWNER_MATCH
        ];

        foreach ($this->value as $optionName => $optionValue) {
            if (!in_array($optionName, $acceptableValues)) {
                return false;
            }
        }

        return true;
    }
}
