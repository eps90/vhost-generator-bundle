<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache\Node;

use Eps\VhostGeneratorBundle\Generator\Apache\Property\DocumentRootProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\ServerAliasProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\ServerNameProperty;
use Eps\VhostGeneratorBundle\Generator\Exception\ValidationException;
use Eps\VhostGeneratorBundle\Generator\Node\NodeInterface;
use Eps\VhostGeneratorBundle\Generator\Property\PropertyInterface;
use Eps\VhostGeneratorBundle\Generator\Property\ValidatablePropertyInterface;

/**
 * Class ApacheVHostNode
 * @package Eps\VhostGeneratorBundle\Generator\Apache\Node
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ApacheVHostNode implements NodeInterface
{
    /**
     * Address and port for Apache VHost in format: [ADDRESS]:[PORT]
     */
    const ADDRESS = 'address';

    /**
     * Regexp for valid IP address or asterisk (*)
     */
    const IP_REGEXP = '/^((?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)|\*)$/';

    /**
     * Regexp for valid port number (0..65535)
     */
    const PORT_NUMBER_REGEXP = '/^([0-9]{1,4}|[1-5][0-9]{4}|6[0-4][0-9]{3}|65[0-4][0-9]{2}|655[0-2][0-9]|6553[0-5])$/';

    /**
     * @var array Attributes of the VHost
     */
    protected $attributes = [
        self::ADDRESS => '*:80'
    ];

    /**
     * @var PropertyInterface[]
     */
    protected $properties = [];

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'VirtualHost';
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Sets the IP Address of the Apache VHost
     *
     * @param string $ipAddress IP Address
     * @param integer|string $port Port number
     *
     * @return self
     * @throws ValidationException
     */
    public function setAddress($ipAddress, $port = 80)
    {
        if (!preg_match(self::IP_REGEXP, $ipAddress) || !preg_match(self::PORT_NUMBER_REGEXP, $port)) {
            throw new ValidationException('Invalid IP address or port number', $ipAddress . ':' . $port);
        }

        $this->attributes[self::ADDRESS] = $ipAddress . ':' . $port;

        return $this;
    }

    /**
     * Sets the document root of Apache VHost
     *
     * @param string|PropertyInterface $documentRoot
     * @return self
     */
    public function setDocumentRoot($documentRoot)
    {
        if (!($documentRoot instanceof PropertyInterface)) {
            $documentRoot = new DocumentRootProperty($documentRoot);
        }

        $this->addProperty(DocumentRootProperty::NAME, $documentRoot);

        return $this;
    }

    /**
     * Sets the server name of Apache VHost
     *
     * @param string|PropertyInterface $serverName
     * @return self
     */
    public function setServerName($serverName)
    {
        if (!($serverName instanceof PropertyInterface)) {
            $serverName = new ServerNameProperty($serverName);
        }

        $this->addProperty(ServerNameProperty::NAME, $serverName);

        return $this;
    }

    /**
     * Sets the server alias of Apache VHost
     *
     * @param string|PropertyInterface $serverAlias
     * @return self
     */
    public function setServerAlias($serverAlias)
    {
        if (!($serverAlias instanceof PropertyInterface)) {
            $serverAlias = new ServerAliasProperty($serverAlias);
        }

        $this->addProperty(ServerAliasProperty::NAME, $serverAlias);

        return $this;
    }

    private function addProperty($propertyName, $propertyObject)
    {
        if ($propertyObject instanceof ValidatablePropertyInterface && !$propertyObject->isValid()) {
            throw new ValidationException(
                'Property is invalid',
                "{$propertyObject->getName()}={$propertyObject->getValue()}"
            );
        }

        $this->properties[$propertyName] = $propertyObject;
    }
}
