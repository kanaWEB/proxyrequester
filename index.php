<?php
//This file isn't secure by itself
//You must create an htaccess file.

//Server configuration is inside secret.php

//Remove theses line to disable errors
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require("lib/webrequest.php");

//Here is the visual part
include("button.php");

//This parts handle proxying actions to Kana
//Pre validation of actions is provided by gump

//For example to enable the first radio switch type
//example.com/?action=radio;1;default;1
if (isset($_GET["action"])) {
    //var_dump($_GET["action"]);

    $action = sanitizeAction($_GET["action"]);
    if($action !== false) {
        $result = action($action);
        //var_dump($result);
    }
}

//If the request was recorrectly sent, Kana will answer an message
if(isset($result) ) {
    echo "<br><code>".$result->type." ".$result->code." ".$result->message."</code>";
}
