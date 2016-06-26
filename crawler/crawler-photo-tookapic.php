<?php 
	define('DRUPAL_ROOT', '/home/vhosts/stock-demo.techblogsearch.com');
	require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
	drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
	include 'functions.php';

	$proxy = "";
	
	/*
	// Processing for 1 detail url https://tookapic.com/photos/122676
	$photo_url = "https://tookapic.com/photos/122676";
	create_node_photo($photo_url,$proxy);
	return;
	*/

	// Process bunch of photos with paging
	for($i = 1; $i < 100; $i++){
		$photo_url_cate = "https://tookapic.com/photos?list=index&page=".$i;
		$html = getResponse($photo_url_cate,$proxy);
		if ($html){
			foreach($html->find('ul.c-list-photo li a.photo__link') as $e) {
				$photo_url = trim($e->href);
				print $photo_url."\n";
				create_node_photo($photo_url,$proxy);
			}
		}
		sleep(1);
	}

?>

<?php 
// Get reponse html data then parser title, description, tags, photo url into array
function photo_url_parser($url, $proxy){
	$nodes = array();
	$html = getResponse($url,$proxy);
		
	if ($html){
		$node_title = "";
		foreach($html->find('h1.u-photo-title') as $e) {
			$node_title = trim($e->plaintext); break;
		}
		print "Title: ".$node_title."\n";
		$nodes['title'] = $node_title;

		$node_desc = "";
		foreach($html->find('.u-photo-description') as $e) {
			$node_desc = trim($e->plaintext); break;
		}
		print "Description: ".$node_desc."\n";
		$nodes['desc'] = $node_desc;

		$node_tags = "";
		foreach($html->find('.tags a') as $e) {
			$item = $e->plaintext; //print $item."\n";
			$node_tags = $node_tags.$item.",";
		}
		$node_tags = rtrim($node_tags,','); // Remote last char ','
		print "Tags: ".$node_tags."\n";
		$nodes['tags'] = $node_tags;

		$node_photo = "";
		foreach($html->find('.lightbox__modal img') as $e) {
			$src = trim($e->src); 
			//$src_base64 = base64_encode($src);
			$node_photo = $src; break;
		}
		print "Photo url: ".$node_photo."\n";
		$nodes['photo'] = $node_photo; // Save node $url_photo as base64 encoded (because there is some issues when saved to MySQL)
		
		print_r($nodes);
		return $nodes;
	} else {
		print "Đã có lỗi xay rả khi get response from ".$url."\n"; return;
	}
	return $nodes;
}

function create_node_photo($url, $proxy){
	// Firstly check if $url is alrealy crawled (I will code this later, store this in Redis)

	$nodes = photo_url_parser($url, $proxy);	// Crawl & Parse html data into array structure

	print "Starting save node into Solr ".$nodes['title']."...\n"	;

	$node = new stdClass();	
	$node->type = "stockphoto"; 
	node_object_prepare($node);

	$node->title    = $nodes['title']; // Title
	$node->language = 'und';
	$node->uid = 1;

	$node->body['und'][0]['value']   = $nodes['desc']; // Description
	$node->body['und'][0]['format']  = 'full_html';


	$node->field_tag['und'][0]['value']   	= $nodes['tags']; // Tags
	$node->field_photo['und'][0]['value']   = $nodes['photo']; // Photo URL
	$node->field_source['und'][0]['value']  = $url; // Source URL

	$node->status = 1; // Publish node (photo) 
	
	node_save($node); // Save photo into Database, Solr will index automatically
}
?>