<?php
$shortlinks = parse_ini_file("links.ini");
if (isset($_GET["r"]) && array_key_exists($_GET["r"], $shortlinks)) {
    header("Location: " . $shortlinks[$_GET["r"]]);
    exit;
} else {
    header("HTTP/1.0 404 Not Found");
}
?>