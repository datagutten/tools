<?php


namespace datagutten\tools\files;


use FilesystemIterator;
use InvalidArgumentException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use UnexpectedValueException;

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
     * @param array $extensions Extensions to find
     * @param bool $recursive Search all sub folders
     * @return array Array with absolute paths to files
     * @throws UnexpectedValueException If the path cannot be found
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
        sort($files);
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

    /**
     * Builds a file path with the appropriate directory separator.
     * Same as os.path.join() in Python
     * @param mixed $segments,... unlimited number of path segments
     * @return string Path
     */
    public static function path_join(...$segments) {
        return join(DIRECTORY_SEPARATOR, $segments);
    }
}
