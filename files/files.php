<?php


namespace datagutten\tools\files;


use FileNotFoundException;

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
        foreach(scandir($path) as $folder)
        {
            if($folder[0]=='.')
                continue;
            if(!is_dir($path.'/'.$folder))
                continue;
            $folders[] = $folder;
        }
        return $folders;
    }

    /**
     * Get valid files in all sub folders
     * @param string $folder Folder to search
     * @param array $extensions Valid extensions
     * @param bool $recursive
     * @return array Find files in sub folders
     * @throws FileNotFoundException Folder not found
     */
    public static function get_files($folder, $extensions, $recursive = true)
    {
        if(!file_exists($folder))
            throw new FileNotFoundException($folder);
        $files = [];
        $dir = @scandir($folder);
        if($dir===false) {
            $error = error_get_last();
            throw new \Exception($error['message']);
        }
        foreach($dir as $file)
        {
            if($file[0]=='.')
                continue;
            if(is_dir($folder.'/'.$file)) {
                if($recursive)
                    $files = array_merge($files, self::get_files($folder . '/' . $file, $extensions));
                else
                    continue;
            }
            else
            {
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                $extension = strtolower($extension);
                if(array_search($extension, $extensions)!==false)
                    $files[] = $folder.'/'.$file;
            }
        }
        return $files;
    }
}
