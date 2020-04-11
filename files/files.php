<?php


namespace datagutten\tools\files;


use FilesystemIterator;
use InvalidArgumentException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class files
{
    /**
     * Get all sub folders
     * @param $path
     * @return array
     */
    public static function sub_folders($path)
    {
        $folders = [];
        /**
         * @var $fileInfo SplFileInfo
         */
        foreach (new FilesystemIterator($path, FilesystemIterator::SKIP_DOTS|FilesystemIterator::UNIX_PATHS) as $fileInfo) {
            if(!$fileInfo->isDir())
                continue;

            $folders[] = $fileInfo->getPathname();
        }
        return $folders;
    }

    /**
     * Get valid files in all sub folders
     * @param string $folder Folder to search
     * @param array $extensions Valid extensions
     * @param bool $recursive
     * @return array Find files in sub folders
     */
    public static function get_files($folder, $extensions = [], $recursive = true)
    {
        $files = [];

        if($recursive)
        {
            $directory = new RecursiveDirectoryIterator($folder, FilesystemIterator::SKIP_DOTS|FilesystemIterator::UNIX_PATHS);
            $iterator = new RecursiveIteratorIterator($directory);
        }
        else
            $iterator = new FilesystemIterator($folder, FilesystemIterator::SKIP_DOTS|FilesystemIterator::UNIX_PATHS);

        /**
         * @var $fileInfo SplFileInfo
         */
        foreach ($iterator as $fileInfo)
        {
            if(!empty($extensions) && array_search($fileInfo->getExtension(), $extensions)===false)
                continue;
            if($fileInfo->isDir())
                continue;
            $files[] = $fileInfo->getPathname();
        }
        return $files;
    }

    /**
     * Find the first file in a directory
     * @param string $dir Directory to be searched
     * @param array $extensions Valid extensions
     * @return string File name with path
     */
    public static function first_file($dir,$extensions = [])
    {
        //https://stackoverflow.com/questions/29102983/order-in-filesystemiterator/33550218
        $files = iterator_to_array(new FilesystemIterator($dir, FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS), true);
        ksort($files);

        /**
         * @var $fileInfo SplFileInfo
         */
        //foreach (new FilesystemIterator($dir, FilesystemIterator::SKIP_DOTS|FilesystemIterator::UNIX_PATHS) as $fileInfo) {
        foreach ($files as $fileInfo)
        {
            if(!$fileInfo->isFile())
                continue;
            if(!empty($extensions) && array_search($fileInfo->getExtension(), $extensions)===false)
                continue;

            return $fileInfo->getPathname();
        }
        throw new InvalidArgumentException('No file found');
    }
}
