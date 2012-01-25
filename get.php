<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
require_once 'mongo_connect.php';
// get documents from mongo
$debug = false;
if(isset($_GET["debug"])){
    $debug = true;
}
error_reporting(E_ALL);

$collection = $db->tweets;



$rangeQuery = array();

$limit = 10;
if(isset($_GET["from"]) && $_GET["from"] !=0){
    $rangeQuery=array("id_str" => array('$gt'=>$_GET["from"]));
    
    $limit = 20;
} 
$cursor = $collection->find($rangeQuery);
//$cursor = $collection->find();
$cursor = $cursor->limit($limit);

//order by id desc
$cursor->sort(array("id_str"=>-1));

//after_id?

// iterate through the results
echo json_encode(iterator_to_array($cursor));
if($debug){

    print_r(iterator_to_array($cursor));

    /*
      foreach ($cursor as $obj) {
        echo $obj["user"]["screen_name"].": ".$obj["text"]." - ".$obj["created_at"]."<br>";
        //print_r($obj);
      }
     * 
     */
}