<?php

if (!function_exists("glob_recursive"))
{
    function glob_recursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);

        foreach (glob(dirname($pattern)."/*", GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
            $files = array_merge($files, glob_recursive($dir."/".basename($pattern), $flags));
        }

        return $files;
    }
}

if (!function_exists("is_excluded"))
{
    function is_excluded($path, array $excludes = [])
    {
        foreach ($excludes as $exclude) {
            $exclude = realpath($exclude);
            if (is_dir($exclude) && strpos($path, $exclude) === 0) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists("opt_key"))
{
    function opt_key(array $default = [])
    {
        $keys    = [];
        $default = array_keys($default);
        foreach ($default as $key) {
            $keys[] = "{$key}:";
        }

        return $keys;
    }
}

if (!function_exists("loc"))
{
    function loc($file)
    {
        $file  = file_get_contents($file);
        $file  = trim($file);

        return substr_count($file, "\n");
    }
}
