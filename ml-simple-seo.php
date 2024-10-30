<?php
/*
Plugin Name: mlSimpleSEO
Plugin URI: http://www.mlipinski.pl/plugins/ml-simple-seo
Description: Plugin added Your own title and meta description tag to each page or post.
Version: 1.0
Author: Michal Lipinski
Author URI: http://www.mlipinski.pl
License: GPLv2
*/

add_action( 'init', 'ml_simple_seo_start');
add_action( 'save_post', 'ml_simple_seo_save_title');
add_action( 'admin_menu', 'ml_simple_seo_backend_start' );


function ml_simple_seo_start(){
	add_filter('wp_title','ml_simple_seo_show_title');
	add_action( 'wp_head', 'ml_simple_seo_show_description');
}

function ml_simple_seo_backend_start(){
	wp_register_style( 'mlsimpleseo-style', plugins_url('/css/mlsimpleseo.css', __FILE__) );
	add_action('add_meta_boxes','ml_simple_seo_add_metabox_page');
}

function ml_simple_seo_add_metabox_page(){
	add_meta_box('ml_simple_seo', 'mlSimpleSEO', 'ml_simple_seo_metabox_page', 'page', 'normal', 'high');
	add_meta_box('ml_simple_seo', 'mlSimpleSEO', 'ml_simple_seo_metabox_page', 'post', 'normal', 'high');
}

function ml_simple_seo_metabox_page($post){
	wp_enqueue_style( 'mlsimpleseo-style' );
	$title=get_post_meta($post->ID,'ml_simple_seo_title',true);
	$description=get_post_meta($post->ID,'ml_simple_seo_description',true);
	?>
	<p class="ml_simple_seo_p">Title Tag</p>
	<input type="text" name="ml_simple_seo_title" id="ml_simple_seo_title" value="<?php echo $title; ?>" /><br /><hr class="ml_simple_seo_hr" />
	<p class="ml_simple_seo_p">Meta Description Tag</p>
	<textarea id="ml_simple_seo_description" name="ml_simple_seo_description"><?php echo $description ?></textarea>
	<?php 
}


function ml_simple_seo_save_title($post_id){
	if(isset($_POST['ml_simple_seo_title'])){
		if (substr($_POST['ml_simple_seo_title'],-1) == ' ') $spacebar=' ';
		else $spacebar='';
		update_post_meta($post_id,'ml_simple_seo_title',sanitize_text_field($_POST['ml_simple_seo_title']).$spacebar);
	}
	if(isset($_POST['ml_simple_seo_description'])){
		update_post_meta($post_id,'ml_simple_seo_description',sanitize_text_field($_POST['ml_simple_seo_description']));
	}
}


//Functions which display vaules 

function ml_simple_seo_show_title($title){
	global $post;
	$titlemeta=get_post_meta($post->ID,'ml_simple_seo_title',true);
	if (isset($titlemeta) && !empty($titlemeta)) return $titlemeta;
	else return $title;
}

function ml_simple_seo_show_description() {
	global $post;
	$description=get_post_meta($post->ID,'ml_simple_seo_description',true);
	if (isset($description) && !empty($description))
	echo '<meta name="description" content="'.$description.'" />';
}
?>