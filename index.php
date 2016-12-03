<?php
use Nullix\Gpiowebinterface\Core;
use Nullix\Gpiowebinterface\View;

include __DIR__ . "/src/Core.php";
Core::init();

$viewClass = "Index";
$url = $_SERVER["REQUEST_URI"];
View::$rootUrl = $url;
// check if we are directly on index.php
preg_match("~(.*?)\/index.php($|\?)~", $url, $match);
if ($match) {
    View::$rootUrl = $match[1];
}
// just check if the given view exists
preg_match("~(.*?)\/index.php\/([a-z]+)~", $url, $match);
if ($match
    && file_exists(__DIR__ . "/src/View/" . ucfirst($match[2]) . ".php")
) {
    $viewClass = ucfirst($match[2]);
    View::$rootUrl = $match[1];
}

View::$rootUrl = rtrim(View::$rootUrl, "/");
$viewClass = "Nullix\\Gpiowebinterface\\View\\" . $viewClass;

$view = new $viewClass;
$view->load();