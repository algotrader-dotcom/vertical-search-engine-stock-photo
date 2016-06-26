<?php 
	define('DRUPAL_ROOT', '/home/vhosts/stock-demo.techblogsearch.com');
	require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
	drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
	include 'functions.php';

	$proxy = "";
	
	// Processing for 1 detail url https://tookapic.com/photos/122676
	$photo_url = "https://tookapic.com/photos/122676";
	$node_photo = photo_url_parser($photo_url); // Photo html parser

?>

<?php 
// Get reponse html data then parser title, description, tags, photo url into array
function photo_url_parser($url, $proxy){
	$nodes = array();
	$html = getResponse($url,$proxy);
		
	if ($html){
		return $nodes;
		
	} else {
		print "Đã có lỗi xay rả khi get response from ".$url."\n"; return;
	}
	return $nodes;
}
?>