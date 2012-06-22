<?php
require_once('phirehose/lib/Phirehose.php');
require_once('phirehose/lib/OauthPhirehose.php');
require_once('mongo_connect.php');
require_once('conf/twitter_config_pvalley.php');

/**
 * Example of using Phirehose to display a live filtered stream using track words 
 */
class FilterTrackConsumer extends OauthPhirehose
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

    /*
     * In this simple example, we will just display to STDOUT rather than enqueue.
     * NOTE: You should NOT be processing tweets at this point in a real application, instead they should be being
     *       enqueued and processed asyncronously from the collection process. 
     */
    $data = json_decode($status, true);
    if (is_array($data) && isset($data['user']['screen_name'])) {
      print $data['user']['screen_name'] . ': ' . urldecode($data['text']) . "\n";
      //print $status;
      $collection->insert($data);
    }
		//exit;
  }
}


// Start streaming
$sc = new FilterTrackConsumer(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_FILTER);
$sc->setTrack(array('playavalley'));
$sc->consume();
