<?php
namespace Nullix\Gpiowebinterface\View;

use Nullix\Gpiowebinterface\Data;
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

        }
        if (post("action") == "readall") {
            $gpios = Data::get("gpios");
            $json = [];
            foreach ($gpios as $key => $row) {
                $out = $ret = "";
                exec("gpio read " . $row["pin"], $out, $ret);
                $json[$key] = isset($out[0]) && $out[0];
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
                                   id="myonoffswitch">
                            <label class="onoffswitch-label"
                                   for="myonoffswitch">
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
