<?php


namespace datagutten\tools\files;


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
     * @return array Files
     */
    public static function get_files($folder, $extensions)
    {
        $files = [];
        foreach(scandir($folder) as $file)
        {
            if($file[0]=='.')
                continue;
            if(is_dir($folder.'/'.$file))
                $files = array_merge($files, self::get_files($folder.'/'.$file, $extensions));
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
