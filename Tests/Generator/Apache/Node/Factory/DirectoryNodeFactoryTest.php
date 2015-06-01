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
}
