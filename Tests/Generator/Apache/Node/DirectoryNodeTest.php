<?php

namespace Eps\VhostGeneratorBundle\Tests\Generator\Apache\Node;

use Eps\VhostGeneratorBundle\Generator\Apache\Node\DirectoryNode;
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
}
