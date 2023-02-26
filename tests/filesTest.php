<?php


use datagutten\tools\files\files;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;


class filesTest extends TestCase
{

    public function setUp(): void
    {
        $dir = __DIR__ . '/test_files';
        mkdir($dir);
        touch($dir . '/test1.txt');
        touch($dir . '/test2.txt');
        touch($dir . '/test1.m4a');
        touch($dir . '/test1.flac');
        mkdir($dir . '/subdir1');
        mkdir($dir . '/subdir2');
        touch($dir . '/subdir1/test1.m4a');
        touch($dir . '/subdir1/test1.flac');
        touch($dir . '/subdir1/test3.txt');
    }

    public function tearDown(): void
    {
        $filesystem = new Filesystem();
        $filesystem->remove(__DIR__ . '/test_files');
    }

    /**
     * @requires PHPUnit 7.0
     */
    public function testGet_files()
    {
        $files = files::get_files(__DIR__ . '/test_files', ['txt']);
        $this->assertEqualsCanonicalizing([
            files::path_join(__DIR__, 'test_files', 'subdir1', 'test3.txt'),
            files::path_join(__DIR__, 'test_files', 'test1.txt'),
            files::path_join(__DIR__, 'test_files', 'test2.txt')
        ], $files);
        $files = files::get_files(__DIR__ . '/test_files', ['txt'], false);
        $this->assertEqualsCanonicalizing([
            files::path_join(__DIR__, 'test_files', 'test1.txt'),
            files::path_join(__DIR__, 'test_files', 'test2.txt')
        ], $files);
    }

    /**
     * @requires PHPUnit 7.0
     */
    public function testGet_filesNoExtension()
    {
        $files = files::get_files(__DIR__ . '/test_files');
        $this->assertEqualsCanonicalizing([
            files::path_join(__DIR__, 'test_files', 'subdir1', 'test1.flac'),
            files::path_join(__DIR__, 'test_files', 'subdir1', 'test1.m4a'),
            files::path_join(__DIR__, 'test_files', 'subdir1', 'test3.txt'),
            files::path_join(__DIR__, 'test_files', 'test1.flac'),
            files::path_join(__DIR__, 'test_files', 'test1.m4a'),
            files::path_join(__DIR__, 'test_files', 'test1.txt'),
            files::path_join(__DIR__, 'test_files', 'test2.txt'),
        ], $files);
    }

    /**
     * @requires PHPUnit 7.0
     */
    public function testGet_filesNoExtensionNoRecursion()
    {
        $files = files::get_files(__DIR__ . '/test_files', [], false);
        $this->assertEqualsCanonicalizing([
            files::path_join(__DIR__, 'test_files', 'test1.flac'),
            files::path_join(__DIR__, 'test_files', 'test1.m4a'),
            files::path_join(__DIR__, 'test_files', 'test1.txt'),
            files::path_join(__DIR__, 'test_files', 'test2.txt'),
        ], $files);
    }

    public function testFirst_file()
    {
        $file = files::first_file(__DIR__ . '/test_files', ['txt']);
        $this->assertEquals(files::path_join(__DIR__, 'test_files', 'test1.txt'), $file);
        $file = files::first_file(__DIR__ . '/test_files', ['flac']);
        $this->assertEquals(files::path_join(__DIR__, 'test_files', 'test1.flac'), $file);
    }

    public function testInvalidFirst_file()
    {
        $this->expectException(InvalidArgumentException::class);
        files::first_file(__DIR__ . '/test_files', ['mp3']);
    }

    /**
     * @requires PHPUnit 7.0
     */
    public function testSub_folders()
    {
        $folders = files::sub_folders(__DIR__ . '/test_files');
        $this->assertEqualsCanonicalizing([
            files::path_join(__DIR__, 'test_files', 'subdir1'),
            files::path_join(__DIR__, 'test_files', 'subdir2')
        ], $folders);
    }

    public function testJoin()
    {
        $folders = files::path_join('foo', 'bar', 'test');
        if (PHP_OS == 'Linux')
        {
            $this->assertEquals('foo/bar/test', $folders);
        }
        elseif (PHP_OS == 'WINNT')
        {
            $this->assertEquals('foo\\bar\\test', $folders);
        }
    }
}
