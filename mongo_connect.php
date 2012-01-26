<?php
require_once './conf/mongo_config.php';
try{
    $mongo = new Mongo();
    $mongo = new Mongo("mongodb://".MONGO_HOST.":".MONGO_PORT);
} catch (Exception $e){
    echo "An error ocurred, cant connect to mongo, check configuration file. <br/> error Message: ".$e->getMessage();
}

$db = $mongo->BIMandments;