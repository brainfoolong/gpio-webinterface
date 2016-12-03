<?php
namespace Nullix\Gpiowebinterface\View;

use Nullix\Gpiowebinterface\Data;
use Nullix\Gpiowebinterface\Gpio;
use Nullix\Gpiowebinterface\View;

/**
 * Class Index
 *
 * @package Nullix\Gpiowebinterface\View
 */
class Index extends View
{
    /**
     * Load
     */
    public function load()
    {
        if (post("action") == "set") {
            Gpio::sendCommand("mode " . post("pin") . " " . post("mode"));
            Gpio::sendCommand("write " . post("pin") . " " . post("value"));
            return;
        }
        if (post("action") == "readall") {
            $gpios = Data::get("gpios");
            $json = [];
            foreach ($gpios as $key => $row) {
                $output = Gpio::sendCommand("read " . $row["pin"]);
                $json[$key] = isset($output[0]) && $output[0];
            }
            echo json_encode($json);
            return;
        }
        parent::load();
    }

    /**
     * Get content for the page
     */
    public function getContent()
    {
        ?>
        <h1 class="spacer">GPIO Control</h1>
        <div class="gpio-buttons row">
            <?php
            $gpios = Data::get("gpios");
            foreach ($gpios as $key => $row) {
                ?>
                <div class="gpio col-xs-6" data-index="<?= $key ?>"
                     data-pin="<?= $row["pin"] ?>"
                     data-mode="<?= $row["mode"] ?>">
                    <div class="inner">
                        <div class="gpio-label"><?= $row["label"] ?></div>
                        <div class="onoffswitch">
                            <input type="checkbox" name="onoffswitch"
                                   class="onoffswitch-checkbox"
                                   id="onoff-<?= $key ?>">
                            <label class="onoffswitch-label"
                                   for="onoff-<?= $key ?>">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
}
