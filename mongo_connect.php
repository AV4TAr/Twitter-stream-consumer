<?php
//DB init
// connects to localhost on port 27017 by default
$mongo = new Mongo();
 
// connects to 192.168.25.190 on port 50100
$mongo = new Mongo("mongodb://127.0.0.1:27017");

$db = $mongo->BIMandments;
?>