<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Apache\Node\Factory;

use Eps\VhostGeneratorBundle\Generator\Apache\Node\DirectoryNode;
use Eps\VhostGeneratorBundle\Generator\Apache\Node\Factory\DirectoryNodeFactory;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\AllowOverrideProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\AllowProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\OptionsProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\RequireProperty;
use org\bovigo\vfs\vfsStream;

/**
 * Class DirectoryNodeFactoryTest
 * @package Eps\VhostGeneratorBundle\Tests\Generator\Apache\Node\Factory
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class DirectoryNodeFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function simpleDirectoryNodeConfigProvider()
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

        $fileSystem = vfsStream::setup('root', null, $structure);

        return [
            'happy_path' => [
                'config' => [
                    'path' => $fileSystem->url() . '/srv/www/data',
                    'allow_override' => [
                        'All'
                    ],
                    'allow' => 'all',
                    'options' => [
                        'ExecCGI',
                        'Indexes'
                    ],
                    'require' => 'all granted'
                ],
                'attributes' => [
                    DirectoryNode::DIRECTORY_PATH => $fileSystem->url() . '/srv/www/data'
                ],
                'properties' => [
                    AllowOverrideProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\AllowOverrideProperty',
                        'value' => 'All'
                    ],
                    AllowProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\AllowProperty',
                        'value' => 'from all'
                    ],
                    OptionsProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\OptionsProperty',
                        'value' => 'ExecCGI Indexes'
                    ],
                    RequireProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\RequireProperty',
                        'value' => 'all granted'
                    ]
                ]
            ],
            'missing_allow_override' => [
                'config' => [
                    'path' => $fileSystem->url() . '/srv/www/data',
                    'allow' => 'all',
                    'options' => [
                        'ExecCGI',
                        'Indexes'
                    ],
                    'require' => 'all granted'
                ],
                'attributes' => [
                    DirectoryNode::DIRECTORY_PATH => $fileSystem->url() . '/srv/www/data'
                ],
                'properties' => [
                    AllowProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\AllowProperty',
                        'value' => 'from all'
                    ],
                    OptionsProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\OptionsProperty',
                        'value' => 'ExecCGI Indexes'
                    ],
                    RequireProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\RequireProperty',
                        'value' => 'all granted'
                    ]
                ]
            ],

            'missing_allow' => [
                'config' => [
                    'path' => $fileSystem->url() . '/srv/www/data',
                    'allow_override' => [
                        'All'
                    ],
                    'options' => [
                        'ExecCGI',
                        'Indexes'
                    ],
                    'require' => 'all granted'
                ],
                'attributes' => [
                    DirectoryNode::DIRECTORY_PATH => $fileSystem->url() . '/srv/www/data'
                ],
                'properties' => [
                    AllowOverrideProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\AllowOverrideProperty',
                        'value' => 'All'
                    ],
                    OptionsProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\OptionsProperty',
                        'value' => 'ExecCGI Indexes'
                    ],
                    RequireProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\RequireProperty',
                        'value' => 'all granted'
                    ]
                ]
            ],

            'missing_options' => [
                'config' => [
                    'path' => $fileSystem->url() . '/srv/www/data',
                    'allow_override' => [
                        'All'
                    ],
                    'allow' => 'all',
                    'require' => 'all granted'
                ],
                'attributes' => [
                    DirectoryNode::DIRECTORY_PATH => $fileSystem->url() . '/srv/www/data'
                ],
                'properties' => [
                    AllowOverrideProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\AllowOverrideProperty',
                        'value' => 'All'
                    ],
                    AllowProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\AllowProperty',
                        'value' => 'from all'
                    ],
                    RequireProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\RequireProperty',
                        'value' => 'all granted'
                    ]
                ]
            ],

            'missing_require' => [
                'config' => [
                    'path' => $fileSystem->url() . '/srv/www/data',
                    'allow_override' => [
                        'All'
                    ],
                    'allow' => 'all',
                    'options' => [
                        'ExecCGI',
                        'Indexes'
                    ]
                ],
                'attributes' => [
                    DirectoryNode::DIRECTORY_PATH => $fileSystem->url() . '/srv/www/data'
                ],
                'properties' => [
                    AllowOverrideProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\AllowOverrideProperty',
                        'value' => 'All'
                    ],
                    AllowProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\AllowProperty',
                        'value' => 'from all'
                    ],
                    OptionsProperty::NAME => [
                        'class' => 'Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\OptionsProperty',
                        'value' => 'ExecCGI Indexes'
                    ]
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider simpleDirectoryNodeConfigProvider
     */
    public function itShouldCreateDirectoryNodeFromConfig($config, $attributes, $properties)
    {
        $factory = new DirectoryNodeFactory();
        $directoryNode = $factory->createNode($config);

        foreach ($attributes as $attributeName => $attributeValue) {
            $attribute = $directoryNode->getAttributes()[$attributeName];
            $this->assertEquals($attribute, $attributeValue);
        }

        foreach ($properties as $propertyName => $propertyOpts) {
            $property = $directoryNode->getProperties()[$propertyName];
            $this->assertInstanceOf($propertyOpts['class'], $property);
            $this->assertEquals($propertyOpts['value'], $property->getValue());
        }
    }

    /**
     * @test
     * @expectedException \Eps\VhostGeneratorBundle\Generator\Exception\MissingPropertyException
     */
    public function itShouldThrowIfDirectoryPathIsMissing()
    {
        $config = [
            'allow_override' => [
                'All'
            ],
            'allow' => 'all',
            'require' => 'all granted'
        ];

        $factory = new DirectoryNodeFactory();
        $factory->createNode($config);
    }
}
