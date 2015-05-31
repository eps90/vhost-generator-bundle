<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Apache\Node;

use Eps\VhostGeneratorBundle\Generator\Apache\Node\DirectoryNode;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\AllowOverrideProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\OptionsProperty;
use Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\RequireProperty;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

/**
 * Class DirectoryNodeTest
 * @package Eps\VhostGeneratorBundle\Tests\Generator\Apache\Node
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class DirectoryNodeTest extends \PHPUnit_Framework_TestCase
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
                    'myDir' => [
                        'sample_file.php' => '<?php echo "OK"; ?>'
                    ]
                ]
            ]
        ];

        $this->fileSystem = vfsStream::setup('root', null, $structure);
    }

    /**
     * @test
     */
    public function itShouldHaveValidName()
    {
        $node = new DirectoryNode();
        $expectedName = 'Directory';
        $actualName = $node->getName();
        $this->assertEquals($expectedName, $actualName);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToSetDirectoryPath()
    {
        $path = $this->fileSystem->url() . '/srv/www/myDir';
        $node = new DirectoryNode();
        $node->setDirectoryPath($path);

        $expectedAttributes = [
            DirectoryNode::DIRECTORY_PATH => $path
        ];
        $actualAttributes = $node->getAttributes();
        $this->assertEquals($expectedAttributes, $actualAttributes);
    }

    /**
     * @test
     * @expectedException \Eps\VhostGeneratorBundle\Generator\Exception\ValidationException
     */
    public function itShouldThrowIfDirectoryPathIsInvalid()
    {
        $invalidPath = '/non/existing/path';
        $node = new DirectoryNode();
        $node->setDirectoryPath($invalidPath);
    }

    /**
     * @test
     */
    public function itShouldAllowToSetOptions()
    {
        $options = [
            OptionsProperty::ALL
        ];
        $node = new DirectoryNode();
        $node->setOptions($options);

        $expectedOptions = 'All';
        /** @var OptionsProperty $actualOptions */
        $actualOptions = $node->getProperties()[OptionsProperty::NAME];
        $this->assertInstanceOf(
            'Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\OptionsProperty',
            $actualOptions
        );
        $this->assertEquals($expectedOptions, $actualOptions->getValue());
    }

    /**
     * @test
     */
    public function itShouldAllowToSetOptionsObject()
    {
        $optionsValues = [
            OptionsProperty::INCLUDES_NO_EXEC
        ];
        $options = new OptionsProperty($optionsValues);
        $node = new DirectoryNode();
        $node->setOptions($options);
        $actualOptions = $node->getProperties()[OptionsProperty::NAME];
        $this->assertEquals($options, $actualOptions);
    }

    /**
     * @test
     * @expectedException \Eps\VhostGeneratorBundle\Generator\Exception\ValidationException
     */
    public function itShouldThrowIfOptionsAreInvalid()
    {
        $options = $this->getMockBuilder(
            'Eps\VHostGeneratorBundle\Generator\Apache\Property\Directory\OptionsProperty'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $options->expects($this->once())
            ->method('isValid')
            ->willReturn(false);
        $node = new DirectoryNode();
        $node->setOptions($options);
    }

    /**
     * @test
     */
    public function itShouldAllowToSetAllowOverrideProperty()
    {
        $options = [
            AllowOverrideProperty::ALL
        ];
        $node = new DirectoryNode();
        $node->setAllowOverride($options);

        /** @var AllowOverrideProperty $actual */
        $actual = $node->getProperties()[AllowOverrideProperty::NAME];
        $this->assertInstanceOf(
            'Eps\VHostGeneratorBundle\Generator\Apache\Property\Directory\AllowOverrideProperty',
            $actual
        );
        $this->assertEquals('All', $actual->getValue());
    }

    /**
     * @test
     */
    public function itShouldAllowToSetAllowOverridePropertyAsObject()
    {
        $optionsValue = [
            AllowOverrideProperty::ALL
        ];
        $options = new AllowOverrideProperty($optionsValue);
        $node = new DirectoryNode();
        $node->setAllowOverride($options);

        /** @var AllowOverrideProperty $actual */
        $actual = $node->getProperties()[AllowOverrideProperty::NAME];;
        $this->assertEquals($options, $actual);
    }

    /**
     * @test
     * @expectedException \Eps\VhostGeneratorBundle\Generator\Exception\ValidationException
     */
    public function itShouldThrowIfAllowOverrideValueIsInvalid()
    {
        $options = $this->getMockBuilder(
            'Eps\VHostGeneratorBundle\Generator\Apache\Property\Directory\AllowOverrideProperty'
        )
            ->disableOriginalConstructor()
            ->getMock();
        $options->expects($this->once())
            ->method('isValid')
            ->willReturn(false);
        $node = new DirectoryNode();
        $node->setAllowOverride($options);
    }

    /**
     * @test
     */
    public function itShouldAllowToAddRequireOption()
    {
        $requireProperty = 'all granted';
        $node = new DirectoryNode();
        $node->setRequire($requireProperty);

        /** @var RequireProperty $require */
        $require = $node->getProperties()[RequireProperty::NAME];
        $this->assertInstanceOf(
            'Eps\VhostGeneratorBundle\Generator\Apache\Property\Directory\RequireProperty',
            $require
        );
        $this->assertEquals($requireProperty, $require->getValue());
    }
}
