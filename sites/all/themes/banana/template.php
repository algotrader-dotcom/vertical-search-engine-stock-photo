<?php

/**
 * @file
 * template.php
 */
function banana_form_alter(&$form, &$form_state, $form_id) {
  //print $form_id;
  if ($form_id == 'search_block_form') {
    //print_r($form);
   //$form['#method'] = 'get';  $form['#action'] = '/search-api.php';
	  $form['search_block_form']['#attributes']['placeholder'] = t('Find products, services, businesses in United State... ');
    //$form['search_block_form']['#attributes']['name'] ='q';
    //print_r($form);
  }
}


//function banana_preprocess_search_results(&$vars) {
  //print_r($vars);
  /*$variables['search_results'] = '';
  foreach ($variables['results'] as $result) {
    $variables['search_results'] .= theme('search_result', $result, $variables['type']);
  }
  $variables['pager'] = theme('pager', NULL, 10, 0);
  $variables['template_files'][] = 'search-results-' . $variables['type'];*/
//}

function banana_preprocess_search_result(&$variables) {
    $variables['info'] = ''; // Remove admin in search result  
    //$variables['type'] = $variables['result']['fields']['bundle_name']; // Add variable $type into search-result.tpl.php
}

function banana_preprocess_node(&$vars) {
  $vars['submitted'] =  t('Posted on !datetime', array('!username' => "", '!datetime' => $vars['date'], ));
}

//-- Enable page template
function banana_preprocess_page(&$vars) {
  if (isset($vars['node']->type)) {
        $nodetype = $vars['node']->type;
        $vars['theme_hook_suggestions'][] = 'page__' . $nodetype;
  }
}


function banana_apachesolr_search_mlt_recommendation_block($vars) {
  if ($vars['delta'] == 'mlt-002'){
      $docs = $vars['docs'];    
      $items = ""; $item = "";
      foreach ($docs as $result) {
        $node_obj = node_load($result->entity_id);

        $node_title = $node_obj->title;
        $node_path = drupal_lookup_path('alias', "node/".$node_obj->nid);
        $node_type = $node_obj->type;
        $node_city = ucfirst(strtolower($node_obj->field_address['und'][0]['locality']));
        $node_add_inline = $node_obj->field_address['und'][0]['thoroughfare']." ".$node_obj->field_address['und'][0]['administrative_area']." ".$node_obj->field_address['und'][0]['country']." ".$node_obj->field_address['und'][0]['postal_code'];

        $city_href = urlencode(strtolower($node_city));
        $item = $item.'<li class="result"><a href="/'.$node_path.'">'.$node_title.'</a><em><a href="/city/'.$city_href.'" class="city">'.$node_city.' </a><span>'.$node_add_inline.'</span></em></li>';
      }

      $items = '<ul class="list-unstyled" style="padding-left: 4px;">'.$item.'</ul>';
      return $items;
   }
}