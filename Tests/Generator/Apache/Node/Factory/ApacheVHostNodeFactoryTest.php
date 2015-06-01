<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Apache\Node\Factory;

use Eps\VhostGeneratorBundle\Generator\Apache\Node\ApacheVHostNode;
use Eps\VhostGeneratorBundle\Generator\Apache\Node\Factory\ApacheVHostNodeFactory;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\DocumentRootProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerAliasProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerNameProperty;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

/**
 * Class ApacheVHostNodeFactoryTest
 * @package Eps\VhostGeneratorBundle\Tests\Generator\Apache\Node\Factory
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class ApacheVHostNodeFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    private $fileSystem;

    /**
     * @before
     */
    public function before()
    {
        $structure = [
            'srv' => [
                'www' => [
                    'data' => [
                        'my_file.php' => "<?php echo 'OK'; ?>"
                    ]
                ]
            ]
        ];

        $this->fileSystem = vfsStream::setup('root', null, $structure);
    }

    public function simpleConfigProvider()
    {
        $structure = [
            'srv' => [
                'www' => [
                    'data' => [
                        'my_file.php' => "<?php echo 'OK'; ?>"
                    ]
                ]
            ]
        ];

        $filesystem = vfsStream::setup('root', null, $structure);

        return [
            'happy_path' => [
                'config' => [
                    'ip_address' => '127.0.0.1',
                    'port' => '8080',
                    'server_name' => 'www.example.com',
                    'server_alias' => 'example.com',
                    'document_root' => $filesystem->url() . '/srv/www/data'
                ],
                'attributes' => [
                    ApacheVHostNode::ADDRESS => '127.0.0.1:8080',
                ],
                'properties' => [
                    ServerNameProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerNameProperty',
                        'value' => 'www.example.com',
                    ],
                    ServerAliasProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerAliasProperty',
                        'value' => 'example.com'
                    ],
                    DocumentRootProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\DocumentRootProperty',
                        'value' => $filesystem->url() . '/srv/www/data'
                    ]
                ]
            ],
            'ip_address_without_port' => [
                'config' => [
                    'ip_address' => '127.0.0.1',
                    'server_name' => 'www.example.com',
                    'server_alias' => 'example.com',
                    'document_root' => $filesystem->url() . '/srv/www/data'
                ],
                'attributes' => [
                    ApacheVHostNode::ADDRESS => '127.0.0.1:80',
                ],
                'properties' => [
                    ServerNameProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerNameProperty',
                        'value' => 'www.example.com',
                    ],
                    ServerAliasProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerAliasProperty',
                        'value' => 'example.com'
                    ],
                    DocumentRootProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\DocumentRootProperty',
                        'value' => $filesystem->url() . '/srv/www/data'
                    ]
                ]
            ],
            'port_without_ip_address' => [
                'config' => [
                    'port' => '80',
                    'server_name' => 'www.example.com',
                    'server_alias' => 'example.com',
                    'document_root' => $filesystem->url() . '/srv/www/data'
                ],
                'attributes' => [
                    ApacheVHostNode::ADDRESS => '*:80',
                ],
                'properties' => [
                    ServerNameProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerNameProperty',
                        'value' => 'www.example.com',
                    ],
                    ServerAliasProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerAliasProperty',
                        'value' => 'example.com'
                    ],
                    DocumentRootProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\DocumentRootProperty',
                        'value' => $filesystem->url() . '/srv/www/data'
                    ]
                ]
            ],
            'no_ip_nor_port' => [
                'config' => [
                    'server_name' => 'www.example.com',
                    'server_alias' => 'example.com',
                    'document_root' => $filesystem->url() . '/srv/www/data'
                ],
                'attributes' => [
                    ApacheVHostNode::ADDRESS => '*:80',
                ],
                'properties' => [
                    ServerNameProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerNameProperty',
                        'value' => 'www.example.com',
                    ],
                    ServerAliasProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\ServerAliasProperty',
                        'value' => 'example.com'
                    ],
                    DocumentRootProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\VHost\DocumentRootProperty',
                        'value' => $filesystem->url() . '/srv/www/data'
                    ]
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider simpleConfigProvider
     */
    public function itShouldCreateSimpleVHostByConfigValues($config, $attributes, $properties)
    {
        $factory = new ApacheVHostNodeFactory();
        /** @var ApacheVHostNode $actual */
        $actual = $factory->createNode($config);

        foreach ($attributes as $attributeName => $attributeValue) {
            $attribute = $actual->getAttributes()[$attributeName];
            $this->assertEquals($attribute, $attributeValue);
        }

        foreach ($properties as $propertyName => $propertyOpts) {
            $property = $actual->getProperties()[$propertyName];
            $this->assertInstanceOf($propertyOpts['class'], $property);
            $this->assertEquals($propertyOpts['value'], $property->getValue());
        }
    }
}
