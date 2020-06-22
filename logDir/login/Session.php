<?php
if(!file_exists(dirname(__FILE__).'/../../config.php')){
    echo "Run install first!";
    die();
}


include dirname(__FILE__).'/../../config.php';

session_start();
if ($_SESSION["iptv"] == true)
{
$iptv = $_SESSION["iptv"];
if($epgMode==3)
    $epgUrl = $_SESSION["epg"];
}
else
{
session_start();
session_destroy();
if($_SERVER['HTTPS'])
    header("Location: https://{$_SERVER['HTTP_HOST']}/{$path}login.php");
else header("Location: http://{$_SERVER['HTTP_HOST']}/{$path}login.php");
die();
return;
}
?>