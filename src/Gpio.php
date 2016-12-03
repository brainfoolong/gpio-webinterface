<?php
namespace Nullix\Gpiowebinterface;

use Nullix\Gpiowebinterface\View\Settings;

/**
 * GPIO Stuff
 */
class Gpio
{
    /**
     * Send commands to omxplayer
     *
     * @param mixed $cmd
     * @return array
     */
    public static function sendCommand($cmd)
    {
        $path = Data::getKey("settings", "gpiopath");
        if (!$path) {
            $path = Settings::$gpioDefaultPath;
        }
        $cmd = "$path $cmd";
        $output = $return = "";
        exec($cmd, $output, $return);
        return $output;
    }
}
