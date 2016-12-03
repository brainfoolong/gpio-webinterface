<?php
namespace Nullix\Gpiowebinterface;

/**
 * Class View
 *
 * @package Nullix\Gpiowebinterface
 */
abstract class View
{
    /**
     * The root url of this application
     *
     * @var string
     */
    public static $rootUrl;

    /**
     * Generate a link to the given view
     *
     * @param string $view
     *
     * @return string
     */
    public static function link($view)
    {
        return View::$rootUrl . "/index.php/" . strtolower($view);
    }

    /**
     * Just load the layout
     */
    public function load()
    {
        header("Content-Type: text/html; charset=UTF-8");
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <meta name="format-detection" content="telephone=no">
            <meta name="msapplication-tap-highlight" content="no">
            <meta name="viewport"
                  content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">
            <link rel="stylesheet" type="text/css"
                  href="<?= View::$rootUrl ?>/stylesheets/bootstrap.min.css">
            <link rel="stylesheet" type="text/css"
                  href="<?= View::$rootUrl ?>/stylesheets/bootstrap-select.min.css">
            <link rel="stylesheet" type="text/css"
                  href="<?= View::$rootUrl ?>/stylesheets/page.css">
            <link rel="shortcut icon"
                  href="<?= View::$rootUrl ?>/images/favicon.ico"
                  type="image/icon"/>
            <script type="text/javascript"
                    src="<?= View::$rootUrl ?>/scripts/jquery-3.1.1.min.js"></script>
            <script type="text/javascript"
                    src="<?= View::$rootUrl ?>/scripts/global.js"></script>
            <?php
            // check if an extra script file for current view exist, if yes include it
            $class = strtolower(basename(str_replace("\\", "/",
                get_class($this))));
            $path = __DIR__ . "/../scripts/view/$class.js";
            if (file_exists($path)) {
                $url = View::$rootUrl . '/scripts/view/' . $class . ".js";
                echo '<script type="text/javascript" src="' . $url
                    . '"></script>';
            }
            ?>
            <title>GPIO Webinterface by BrainFooLong</title>
            <script type="text/javascript">
                owg.translations = <?=json_encode(Translation::$values)?>;
                owg.language = '<?=Data::getKey("settings", "language")?>';
                if (owg.language == '') {
                    owg.language = "en";
                }
                owg.rootUrl = '<?=View::$rootUrl?>';
                owg.settings = <?=json_encode(Data::get("settings"))?>;
                owg.gpios = <?=json_encode(Data::get("gpios"))?>;
            </script>
        </head>
        <body>

        <div id="wrapper">
            <div class="overlay"></div>
            <button type="button" class="hamburger is-closed"
                    data-toggle="offcanvas">
                <span class="hamb-top"></span>
                <span class="hamb-middle"></span>
                <span class="hamb-bottom"></span>
            </button>
            <nav class="navbar navbar-inverse navbar-fixed-top"
                 id="sidebar-wrapper" role="navigation">
                <ul class="nav sidebar-nav">
                    <li class="sidebar-brand">
                        <div><img src="<?= View::$rootUrl ?>/images/logo.png">
                        </div>
                    </li>
                    <li>
                        <a href="<?= View::link("index") ?>">GPIOs</a>
                    </li>
                    <li>
                        <a href="<?= View::link("settings") ?>"><?= t("settings") ?></a>
                    </li>
                    <li>
                        <a href="https://github.com/brainfoolong/gpio-webinterface"
                           target="_blank">Github</a>
                    </li>
                    <li>
                        <a href="https://github.com/brainfoolong/gpio-webinterface/issues"
                           target="_blank">Issues</a>
                    </li>
                </ul>
            </nav>
            <div id="page-content-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="spinner-container"></div>
                            <div class="page-content">
                                <a class="top-logo"
                                   href="https://github.com/brainfoolong/gpio-webinterface"
                                   target="_blank">
                                    <strong>GPIO WEBINTERFACE</strong>
                                    <small>by BrainFooLong</small>
                                </a>
                                <?= $this->getContent() ?>
                            </div>
                            <script type="text/javascript">
                                spinner(".spinner-container");
                                $(".page-content").addClass("hidden");
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript"
                src="<?= View::$rootUrl ?>/scripts/bootstrap.min.js"></script>
        <script type="text/javascript"
                src="<?= View::$rootUrl ?>/scripts/bootstrap-select.min.js"></script>
        </body>
        </html>
        <?php
    }

    /**
     * Get content for the page
     */
    abstract public function getContent();
}
