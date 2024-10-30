<?php
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();
  
  $allposts = get_posts('numberposts=-1&post_type=post&post_status=any');
  foreach( $allposts as $postinfo) {
    delete_post_meta($postinfo->ID, 'ml_simple_seo_title');
    delete_post_meta($postinfo->ID, 'ml_simple_seo_description');
  }
  $allposts = get_posts('numberposts=-1&post_type=page&post_status=any');
  foreach( $allposts as $postinfo) {
    delete_post_meta($postinfo->ID, 'ml_simple_seo_title');
    delete_post_meta($postinfo->ID, 'ml_simple_seo_description');
  }
?>