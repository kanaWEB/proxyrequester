<?php
//This file isn't secure by itself
//You must create an htaccess file.
//

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include("secret.php");
include("webrequest.php"); //Manage
?>

<link rel="stylesheet" href="bootstrap.min.css">

<div class="btn-group">
<a class="btn btn-success" href="?action=radio;1;default;1">ON</a>
<a class="btn btn-danger" href="?action=radio;1;off;1">OFF</a>
</div>

<?php
if(isset($result)){
echo "<br><code>".$result->type." ".$result->code." ".$result->message."</code>";
}