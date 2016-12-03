<?php
namespace Nullix\Gpiowebinterface\View;

use Nullix\Gpiowebinterface\Data;
use Nullix\Gpiowebinterface\View;

/**
 * Class Settings
 *
 * @package Nullix\Gpiowebinterface\View
 */
class Settings extends View
{

    /**
     * The gpio default path
     * @var string
     */
    public static $gpioDefaultPath = "/usr/local/bin/gpio";

    /**
     * Get content for the page
     */
    public function getContent()
    {
        if (post("save-gpios")) {
            $gpios = null;
            $postGpios = post("gpio");
            if (is_array($postGpios)) {
                foreach ($postGpios as $key => $value) {
                    foreach ($postGpios[$key] as $subKey => $subValue) {
                        $gpios[$subKey][$key] = $subValue;
                    }
                }
                foreach ($gpios as $key => $row) {
                    if (!$row["label"] || $row["pin"] == "") {
                        unset($gpios[$key]);
                    }
                }
                $gpios = array_values($gpios);
            }
            Data::set("gpios", $gpios);
            echo '<div class="btn btn-success note">' . t("saved") . '</div>';
        }
        if (post("save-settings")) {
            $settings = Data::get("settings");
            $postSettings = post("setting");
            if (is_array($postSettings)) {
                foreach ($postSettings as $key => $value) {
                    $settings[$key] = $value;
                }
                Data::set("settings", $settings);
            }
            echo '<div class="btn btn-success note">' . t("saved") . '</div>';
        }
        ?>
        <h1>GPIO's</h1>
        <form name="gpio" method="post" action="">
            <div class="row">
                <div class="col-xs-4">
                    Label
                </div>
                <div class="col-xs-2">
                    Pin
                </div>
                <div class="col-xs-2">
                    Mode
                </div>
                <div class="col-xs-2">
                    PWM max.
                </div>
                <div class="col-xs-2">

                </div>
            </div>
            <div class="gpios spacer">
                <div class="row hidden">
                    <div class="col-xs-4">
                        <input type="text" name="gpio[label][]"
                               class="form-control">
                    </div>
                    <div class="col-xs-2">
                        <input type="number" placeholder="" name="gpio[pin][]"
                               class="form-control" step="1">
                    </div>
                    <div class="col-xs-2">
                        <select class="selectpicker" name="gpio[mode][]">
                            in/out/pwm/clock/up/down/tri
                            <option value="in">in</option>
                            <option value="out">out</option>
                            <option value="pwm">pwm</option>
                            <option value="clock">clock</option>
                            <option value="up">up</option>
                            <option value="down">down</option>
                            <option value="tri">tri</option>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <input type="number" placeholder=""
                               name="gpio[pwmmax][]"
                               class="form-control" step="1" max="1023" min="0">
                    </div>
                    <div class="col-xs-2">
                        <span class="btn btn-default btn-danger delete-gpio">X</span>
                    </div>
                </div>
            </div>

            <div class="spacer">
                <span class="btn btn-default btn-xs add-gpio"><?= t("settings.gpio.add") ?></span>
            </div>
            <input type="submit" value="<?= t("save") ?>" name="save-gpios"
                   class="btn btn-default btn-info">
        </form>


        <h1><?= t("settings") ?></h1>
        <form name="settings" method="post" action="">
            <div class="title spacer">
                <strong><?= t("settings.gpiopath.title") ?></strong>
                <small><?= t("settings.gpiopath.desc") ?></small>
            </div>
            <div class="spacer">
                <input type="text"
                       placeholder="<?=self::$gpioDefaultPath?>"
                       name="setting[gpiopath]"
                       class="form-control">
            </div>

            <div class="title spacer">
                <strong><?= t("settings.language.title") ?></strong>
                <small><?= t("settings.language.desc") ?></small>
            </div>
            <div class="spacer">
                <select class="selectpicker" name="setting[language]">
                    <option value="en">English</option>
                    <option value="de">Deutsch</option>
                </select>
            </div>
            <input type="submit" value="<?= t("save") ?>" name="save-settings"
                   class="btn btn-default btn-info">
        </form>
        <script type="text/javascript">
            owg.settings = <?=json_encode(Data::get("settings"))?>;
            owg.gpios = <?=json_encode(Data::get("gpios"))?>;
        </script>
        <?php
    }
}
