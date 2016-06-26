<?php 
  //print_r($node);
?>
<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php if ($title_prefix || $title_suffix || $display_submitted || !$page): ?>
  <header>
    <?php print render($title_prefix); ?>
    <?php if (!$page): ?>
      <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print html_entity_decode(trim($title), ENT_QUOTES, 'UTF-8'); ?></a></h2>
    <?php endif; ?>
    <?php print render($title_suffix); ?>

    <?php if ($display_submitted): ?>
      <div class="submitted">
        <?php print $user_picture; ?>
        <span class="glyphicon glyphicon-calendar"></span> <?php print $submitted; ?>
      </div>
    <?php endif; ?>
  </header>
  <?php endif; ?>

  <div class="content"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      hide($content['field_tags']);
      //print render($content);
      print "<h4>".$title."</h4>";
      print $node->body['und'][0]['value'];

      print '<div style="width:100%;float:left;margin-top:5px;margin-bottom:5px;">';
      print '<img class="is-loading is-loaded" style="max-width: 500px;" src="'.$node->field_photo['und'][0]['value'].'">';
      print '</div>';
 
      print "Tags: ".$node->field_tag['und'][0]['value']."<br>";
      print "Original URL: ".'<a target="_blank" href="'.$node->field_source['und'][0]['value'].'">'.$node->field_source['und'][0]['value'].'</a>';
    ?>
  </div>
    
    <?php if (($tags = render($content['field_tags'])) || ($links = render($content['links']))): ?>
    <footer>
    <?php print render($content['field_tags']); ?>
    <?php print render($content['links']); ?>
    </footer>
    <?php endif; ?> 

  <?php print render($content['comments']); ?>

</article>