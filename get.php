<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
require_once 'mongo_connect.php';
// get documents from mongo
error_reporting(E_ALL);

$collection = $db->tweets;

$cursor = $collection->find();//->limit(10);

$rangeQuery = array("_id"=>-1);

if(isset($_GET["from"]) && $_GET["from"] !=0){
    $rangeQuery["_id"]=array('$gt'=>$_GET["from"]);
} else {
    //get the last 10
    $cursor = $cursor->limit(10);
}


$cursor->sort($rangeQuery);

//after_id?

// iterate through the results
echo json_encode(iterator_to_array($cursor));
/*
echo '<pre>';
print_r(iterator_to_array($cursor));
echo '</pre>';
/*
  foreach ($cursor as $obj) {
    echo $obj["user"]["screen_name"].": ".$obj["text"]." - ".$obj["created_at"]."<br>";
    //print_r($obj);
  }
 * 
 */
