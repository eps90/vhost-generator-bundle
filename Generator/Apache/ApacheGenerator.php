<?php

namespace Eps\VhostGeneratorBundle\Generator\Apache;

use Eps\VhostGeneratorBundle\Generator\Formatter\ConfigurationFormatterInterface;
use Eps\VhostGeneratorBundle\Generator\GeneratorInterface;
use Eps\VhostGeneratorBundle\Generator\Node\Factory\NodeFactoryInterface;

/**
 * Class ApacheGenerator
 * @package Eps\VhostGeneratorBundle\Generator\Apache
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ApacheGenerator implements GeneratorInterface
{
    /**
     * @var NodeFactoryInterface
     */
    private $factory;

    /**
     * @var ConfigurationFormatterInterface
     */
    private $formatter;

    public function __construct(NodeFactoryInterface $factory, ConfigurationFormatterInterface $formatter)
    {
        $this->factory = $factory;
        $this->formatter = $formatter;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(array $config)
    {
        $node = $this->factory->createNode($config);
        $config = $this->formatter->createConfig([$node]);

        return $config;
    }
}
