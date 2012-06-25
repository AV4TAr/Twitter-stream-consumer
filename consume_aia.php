<?php
require_once('phirehose/lib/Phirehose.php');
require_once('phirehose/lib/OauthPhirehose.php');
require_once('mongo_connect_aia.php');
require_once('conf/twitter_config_aia.php');
/**
 * Example of using Phirehose to display a live filtered stream using geo locations 
 */
class FilterTrackConsumer extends Phirehose
{
  /**
   * Enqueue each status
   *
   * @param string $status
   */
  public function enqueueStatus($status)
  {
     global $db;
  	
    //Use this collection
    $collection = $db->pvalley; 
    
    $data = json_decode($status, true);
    if (is_array($data) && isset($data['user']['screen_name'])) {
      print $data['user']['screen_name'] . ': ' . urldecode($data['text']) . "\n";
      //print $status;
      $collection->insert($data);
    }
  }
}

// Start streaming
$sc = new FilterTrackConsumer(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_FILTER);
$sc->setLocations(array(
       //array(-122.75, 36.8, -121.75, 37.8), // San Francisco
       array(-74, 40, -73, 41),             // New York 
   ));
$sc->consume();