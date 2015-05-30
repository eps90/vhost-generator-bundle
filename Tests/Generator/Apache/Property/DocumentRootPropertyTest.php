<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Apache\Property;

use Eps\VhostGeneratorBundle\Generator\Apache\Property\DocumentRootProperty;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

/**
 * Class DocumentRootPropertyTest
 * @package Eps\VhostGeneratorBundle\Tests\Generator\Apache\Property
 * @author Jakub Turek <ja@kubaturek.pl>
 */
class DocumentRootPropertyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    private $filesystemMock;

    private $validFsPath;
    private $validFsDir;

    /**
     * @before
     */
    public function before()
    {
        $filesystem = [
            'srv' => [
                'www' => [
                    'myDir' => [
                        'sample_file.php' => '<?php echo "OK"; ?>'
                    ]
                ]
            ]
        ];

        $this->filesystemMock = vfsStream::setup('root', null, $filesystem);
        $this->validFsPath = $this->filesystemMock->url() . '/srv/www/myDir/sample_file.php';
        $this->validFsDir = $this->filesystemMock->url() . '/srv/www/myDir';
    }

    /**
     * @test
     */
    public function itShouldHaveName()
    {
        $property = new DocumentRootProperty($this->validFsPath);
        $expectedName = 'DocumentRoot';
        $actualName = $property->getName();

        $this->assertEquals($expectedName, $actualName);
    }

    /**
     * @test
     */
    public function itShouldHaveValidValue()
    {
        // File
        $property = new DocumentRootProperty($this->validFsPath);
        $this->assertSame($this->validFsPath, $property->getValue());
        $this->assertTrue($property->isValid());

        // Directory
        $property = new DocumentRootProperty($this->validFsDir);
        $this->assertSame($this->validFsDir, $property->getValue());
        $this->assertTrue($property->isValid());
    }

    /**
     * @test
     */
    public function itShouldValidateWhetherFileOrDirectoryExists()
    {
        $invalidFilePath = 'some/invalid/path';
        $property = new DocumentRootProperty($invalidFilePath);
        $this->assertFalse($property->isValid());
    }
}
