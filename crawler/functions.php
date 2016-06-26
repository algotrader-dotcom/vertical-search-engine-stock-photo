<?php 
define('DRUPAL_ROOT', '/home/vhosts/stock-demo.techblogsearch.com');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

require_once('simple_html_dom.php');


// Get html response data from URL 
function getResponse($url, $proxy){
	$html = "";
	$ch = curl_init();	
	$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
    $timeout = 0; // set to zero for no timeout	
	if ($proxy != ""){
		curl_setopt($ch, CURLOPT_PROXY, $proxy);
	}
	
	curl_setopt($ch, CURLOPT_VERBOSE, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_ENCODING , "gzip"); 
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_URL, $url);
	$http_data = curl_exec($ch);
	
	$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	//print "getResponse: status code: ".$http_status."\n";

	curl_close($ch);
	
	$html = str_get_html($http_data);
	return $html;
}
?>