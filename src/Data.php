<?php
namespace Nullix\Gpiowebinterface;

/**
 * Simple json data storage
 *
 * @package Nullix\Gpiowebinterface
 */
class Data
{
    /**
     * Cache for the files
     *
     * @var array
     */
    private static $cache;

    /**
     * Read a data file from disk and get a specific key from the values array
     *
     * @param string $file
     * @param string $key
     *
     * @return mixed
     */
    public static function getKey($file, $key)
    {
        $data = self::get($file);
        if (is_array($data) && isset($data[$key])) {
            return $data[$key];
        }
    }

    /**
     * Set a specific data value for the given key
     *
     * @param string $file
     * @param string $key
     * @param mixed  $value
     */
    public static function setKey($file, $key, $value)
    {
        $data = self::get($file);
        $data[$key] = $value;
        self::set($file, $data);
    }

    /**
     * Read a data file from disk
     *
     * @param string $file
     *
     * @return mixed
     */
    public static function get($file)
    {
        if (isset(self::$cache[$file])) {
            return self::$cache[$file];
        }
        $path = __DIR__ . "/../data/$file.json";
        if (!file_exists($path) || !is_readable($path)) {
            return null;
        }
        return json_decode(file_get_contents($path), true);
    }

    /**
     * Write a data file to disk
     *
     * @param string $file
     * @param mixed  $value Any value to store in the file
     *
     * @throws \Exception
     */
    public static function set($file, $value)
    {
        $path = __DIR__ . "/../data/$file.json";
        if (!is_dir(dirname($path)) || !is_writable(dirname($path))) {
            throw new \Exception("'data' directory does not exist or is not writeable");
        }
        if (file_exists($path) && !is_writable($path)) {
            throw new \Exception("'$path' file is not writeable");
        }
        // delete file if null is given
        if ($value === null) {
            unset(self::$cache[$file]);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        // if a mutex file exist (other write progress not finished) than just wait a second
        // every write progress should not last longer than 1 second
        // we do not save such huge files to disk
        $mutex = $path . ".mutex";
        if (file_exists($mutex) && filemtime($mutex) > time() - 1) {
            sleep(1);
            // delete mutex file anyway
            unlink($mutex);
        }
        $json = json_encode($value);
        // create mutex
        file_put_contents($mutex, "");
        // write file
        file_put_contents($path, $json);
        // delete mutex
        unlink($mutex);
        // set cache
        self::$cache[$file] = $value;
    }
}
