<?php

namespace {

    use Nullix\Gpiowebinterface\Data;
    use Nullix\Gpiowebinterface\Translation;

    /**
     * Get a post value
     *
     * @param string $key
     *
     * @return mixed
     */
    function post($key)
    {
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }

    /**
     * Get a get value
     *
     * @param string $key
     *
     * @return mixed
     */
    function get($key)
    {
        return isset($_GET[$key]) ? $_GET[$key] : null;
    }

    /**
     * Get a translation key
     *
     * @param string $key
     * @param mixed  $parameters Parameters to replace
     *
     * @return mixed
     */
    function t($key, $parameters = null)
    {
        $lang = Data::getKey("settings", "language");
        if (!$lang) {
            $lang = "en";
        }

        $value = null;
        if (isset(Translation::$values[$lang][$key])) {
            $value = Translation::$values[$lang][$key];
        } else {
            if (isset(Translation::$values["en"][$key])) {
                $value = Translation::$values["en"][$key];
            } else {
                $value = $key;
            }
        }
        if (is_array($parameters)) {
            foreach ($parameters as $key => $v) {
                $value = str_replace('{' . $key . '}', $v, $value);
            }
        }
        return $value;
    }
}

namespace Nullix\Gpiowebinterface {

    /**
     * Class Core
     *
     * @package Nullix\Gpiowebinterface
     */
    class Core
    {

        /**
         * The current version
         *
         * @var string
         */
        public static $version = "0.9.0";

        /**
         * Initialize
         */
        public static function init()
        {

            ini_set("display_errors", 1);
            error_reporting(E_ALL);
            ini_set("zlib.output_compression", 4096);

            mb_internal_encoding("UTF-8");
            mb_http_input("UTF-8");
            mb_http_output("UTF-8");
            mb_language("uni");

            mb_detect_order(
                "UTF-8, UTF-7, ISO-8859-1, ASCII, EUC-JP, SJIS, eucJP-win, "
                . "SJIS-win, JIS, ISO-2022-JP, Windows-1251, Windows-1252"
            );

            ob_start();

            spl_autoload_register(function ($class) {

                // project-specific namespace prefix
                $prefix = 'Nullix\\Gpiowebinterface\\';

                // base directory for the namespace prefix
                $base_dir = __DIR__ . '/';

                // does the class use the namespace prefix?
                $len = strlen($prefix);
                if (strncmp($prefix, $class, $len) !== 0) {
                    // no, move to the next registered autoloader
                    return;
                }

                // get the relative class name
                $relative_class = substr($class, $len);

                // replace the namespace prefix with the base directory, replace namespace
                // separators with directory separators in the relative class name, append
                // with .php
                $file = $base_dir . str_replace('\\', '/', $relative_class)
                    . '.php';

                // if the file exists, require it
                if (file_exists($file)) {
                    require $file;
                }
            });
        }
    }
}
