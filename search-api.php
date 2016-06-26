<?php 
	define('DRUPAL_ROOT', '/home/vhosts/stock-demo.techblogsearch.com');
	require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
	drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
	
	//$q = 'label:nhan vien kinh doanh '.'AND'.' ts_job_location:Hồ Chí Minh';
	//$q = 'label:asset';
	$q = $_GET['q'];
	//print $q;return;
	
	// Init Solr Object
	$query = apachesolr_drupal_query();

	// Query param
	$query->addParam(q, $q_param);	
  	
  	// Fields will be hightlighted in results
	$query->addParam('hl', true); // Set hightlight
	$query->addParam('hl.fl', label);
	$query->addParam('hl.fl', teaser);

	// Facet Results
    //$query->addParam('facet', true); 
    //$query->addParam('facet.field', 'ts_company_sic_name'); 

    // Paging
    $query->page = $p;

	apachesolr_search_add_boost_params($query);
	try{
	  	list($final_query, $response) = apachesolr_do_query($query);

	  	if ($response->code == '200' && $response->response->numFound > 0) {
	  		$numFound = $response->response->numFound;
	  		$results = apachesolr_search_process_response($response, $query); // Process response from Apache Solr to be more beautiful including highlight snippets (Module Rich Snippets must be DISABLED)
	  		//print_r($results);
		}
	} catch  (Exception $e) {
	  watchdog('solr_search', 'There was an error while searching: %error', array('%error' => $e->getMessage()), WATCHDOG_ERROR);
	}
	//return;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN"  "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces;?>>
<head profile="<?php print $grddl_profile; ?>">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php print drupal_get_html_head(); ?>
  <?php print drupal_get_css(); ?>
  <?php print drupal_get_js(); ?>
  <link type="text/css" rel="stylesheet" href="/custom.css" media="all" />
</head>

<body class="html not-front not-logged-in one-sidebar sidebar-second page-search page-search-site page-search-site-medicine">
    <header style="margin-top:0px;" class="navbar container-fluid navbar-default" role="banner" id="navbar">
		<div class="container-fluid">
		    <div class="navbar-header">		 
		        <a class="name navbar-brand" href="/" title="Home">Stock Photo Search</a>
		        <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		    </div>

		    <div class="navbar-collapse collapse">
		        <nav role="navigation">
		        	<ul class="menu nav navbar-nav"><li class="first leaf"><a href="" title="">Popular Searches</a></li>
						<li class="last leaf"><a href="/business-by-category" title="">Browse Tags</a></li>
					</ul>                                      
				</nav>
		    </div>
		</div>
	</header>

	<div class="main-container container">
	  	<header id="page-header" role="banner">    
		    <div class="region region-header">
			    <section class="block block-search clearfix" id="block-search-form">
				  	<form accept-charset="UTF-8" id="search-block-form" method="get" action="/search-api.php" class="form-search content-search">
				  		<div>
					  		<div>
								<div class="input-group">
									<input type="text" maxlength="128" size="15" value="" name="q" class="form-control form-text" placeholder="Type your keywords..." title=""><span class="input-group-btn"><button class="btn btn-primary btn-search" type="submit"><span aria-hidden="true" class="icon glyphicon glyphicon-search"></span></button></span></div><div id="edit-actions" class="form-actions form-wrapper form-group"><button value="Search" name="op" id="edit-submit" type="submit" class="element-invisible btn btn-primary form-submit">Search</button>
								</div>
							</div>
						</div>
					</form>
				</section>
		  	</div>
	  	</header> <!-- /#page-header -->

	  	<div id="list-search-result-wrapper" class="row">
			<?php foreach($results as $result){ 
				//print_r($result);return;
				$r_photo =  $result['fields']['sm_field_photo'][0];
				$r_tags = $result['fields']['sm_field_tag'][0];

				$r_title = $result['title']; 
				$r_href = $result['link']; 
				$r_snippet = htmlspecialchars_decode($result['snippet'], ENT_QUOTES);

			?>
			<div id="img-b66d369b4c9c06e1" class="col-md-3 img-wrapper clear-margin">
				<div class="img-box">
				    <img class="img-popover" src="<?php print $r_photo; ?>">
				</div>

				<div class="image-desc">
				    <h5>
				      <span class="pull-left"><?php print $r_title; ?></span>
				      <span class="pull-left"><?php //print $r_tags; ?></span>
				      <div class="clear"></div>
				    </h5>
				</div>
			</div>
			<?php } ?>
	  	</div>
	</div> 
</body>
</html>