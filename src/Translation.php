<?php
namespace Nullix\Gpiowebinterface;

/**
 * Class Translation
 *
 * @package Nullix\Gpiowebinterface
 */
class Translation
{

    /**
     * All translation values
     *
     * @var array
     */
    public static $values
        = [
            "en" => [
                "yes" => "Yes",
                "no" => "No",
                "enabled" => "Enabled",
                "disabled" => "Disabled",
                "save" => "Save",
                "saved" => "Saved",
                "delete" => "Delete",
                "settings" => "Settings",
                "settings.language.title" => "Language",
                "settings.language.desc" => "Select the language for the web interface",
                "settings.gpiopath.title" => "GPIO executable path",
                "settings.gpiopath.desc" => "Point to the executable file, find the path with 'whereis gpio' in your console",
                "settings.gpio.add" => "Add another GPIO"

            ],
            "de" => [
                "yes" => "Ja",
                "no" => "Nein",
                "enabled" => "Aktiviert",
                "disabled" => "Deaktiviert",
                "save" => "Speichern",
                "saved" => "Gespeichert",
                "delete" => "Löschen",
                "settings.language.title" => "Sprache",
                "settings.language.desc" => "Wähle eine Sprache für das Webinterface",
                "settings.gpiopath.title" => "GPIO Executable Pfad",
                "settings.gpiopath.desc" => "Zeige auf die Executable von gpio. Finde es via 'whereis gpio' in der Konsole",
                "settings.gpio.add" => "Weiteren GPIO hinzufügen"
            ]
        ];
}
