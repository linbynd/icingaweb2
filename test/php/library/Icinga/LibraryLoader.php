<?php
namespace Icinga\Test;

abstract class LibraryLoader {

    public static function getBasePath()
    {
        $path = realpath(dirname(__FILE__));
        while (!preg_match('/.*test$/', $path) && $path != '/') {
            $path = realpath($path.'/../');
        }
        return realpath($path.'/../');
    }

    public static function getLibraryPath()
    {
        return realpath(self::getBasePath().'/library/Icinga/');
    }

    public static function getModulePath($module = '')
    {
        return realpath(self::getBasePath().'/module/'.$module);
    }

    /**
     * Require all php files in the folder $folder
     *
     * @param $folder   The path to the folder containing PHP files
     */
    public static function loadFolder($folder, $recursive = true)
    {
        $files = scandir($folder);
        foreach ($files as $file) {
            if ($file[0] == '.') {
                continue;
            }
            if ($recursive && is_dir(realpath($folder."/".$file))) {

                self::loadFolder(realpath($folder."/".$file));
            }
            if (!preg_match('/php$/', $file)) {
                continue;
            }
            require_once(realpath($folder.'/'.$file));
        }
    }

    /**
     * Should be abstract but in php this should not be
     */
    public static function requireLibrary()
    {
    }
}
