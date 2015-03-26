<?php
/*
Plugin Name: Custom Post Type 
Description: Declares a plugin that will create a custom post type displaying cakes.
Version: 1.0
*/

// making custom post type
function my_custom_post_cakes() {

// setting up labels for custom post type
$labels = array(
    'name'               => _x( 'Cakes', 'post type general name' ),
    'singular_name'      => _x( 'Cake', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'cake' ),
    'add_new_item'       => __( 'Add New Cakes' ),
    'edit_item'          => __( 'Edit Cake' ),
    'new_item'           => __( 'New Cake' ),
    'all_items'          => __( 'All Cakes' ),
    'view_item'          => __( 'View Cake' ),
    'search_items'       => __( 'Search Cakes' ),
    'not_found'          => __( 'No cakes found' ),
    'not_found_in_trash' => __( 'No cakes found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Cakes'
  );
  //set other options for Custom post type
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds our cakes products data',
    'public'        => true,
    'menu_position' => 5,
    //Features this custom post type in post editor
    'supports'      => array('title','thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
  );
//In WordPress the register_post_type() is a function which is recognized as a custom post type generator. It accepts two parameters: the name of the post type and any arguments you would like to call.
  register_post_type( 'cake', $args ); 
}
//This line of code returns or calls our function so it fires and displays within our site.
add_action( 'init', 'my_custom_post_cakes' );
//You can associate this custom post type with a taxonomy or custom taxonomy and creates taxonomies for cake products 
function my_taxonomies_cake() {
	//setting up taxonomies properties
  $labels = array(
    'name'              => _x( 'Cake Categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'Cake Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Cake Categories' ),
    'all_items'         => __( 'All Cake Categories' ),
    'parent_item'       => __( 'Parent Cake Category' ),
    'parent_item_colon' => __( 'Parent Cake Category:' ),
    'edit_item'         => __( 'Edit Cake Category' ), 
    'update_item'       => __( 'Update Cake Category' ),
    'add_new_item'      => __( 'Add New Cake Category' ),
    'new_item_name'     => __( 'New Cake Category' ),
    'menu_name'         => __( 'Cake Categories' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );
  //this allows to register custom post type
  register_taxonomy( 'cake_category', 'cake', $args );
}
add_action( 'init', 'my_taxonomies_cake', 0 );

//  making all custom fields for Flavor, Author name and Recipe 
function cake_author_box() {
	 add_meta_box( 
        'cake_author_box',
        __( 'Author', 'myplugin_textdomain' ),
        'cake_author_box_content',
        'cake',
        'normal',
        'high'
    );	
}
add_action( 'add_meta_boxes', 'cake_author_box' );

function cake_flavor_box() {
     add_meta_box( 
        'cake_flavor_box',
        __( 'Flavor name', 'myplugin_textdomain' ),
        'cake_flavor_box_content',
        'cake',
        'normal',
        'high'
    );	
}
add_action( 'add_meta_boxes', 'cake_flavor_box' );

function cake_recipe_box() {
     add_meta_box( 
        'cake_recipe_box',
        __( 'Cake Recipe', 'myplugin_textdomain' ),
        'cake_recipe_box_content',
        'cake',
        'normal',
        'high'
    );	
}
add_action( 'add_meta_boxes', 'cake_recipe_box' );

// adding html content for each custom field

function cake_flavor_box_content( $post ) {
  wp_nonce_field( 'cake_flavor_box', 'cake_flavor_box_content_nonce' );
  $value = get_post_meta( get_the_ID(), '_cake_flavor', true );
  echo '<label for="cake_flavor"></label>';
  echo '<input type="text" style="width:100%;" value="' . esc_attr( $value ) . '" id="cake_flavor" name="cake_flavor" placeholder="eg. Chocolate" />';
}

function cake_author_box_content( $post ) {
  wp_nonce_field( 'cake_author_box', 'cake_author_box_content_nonce' );
  $value = get_post_meta( get_the_ID(), '_cake_author', true );
  echo '<label for="cake_author"></label>';
  echo '<input type="text" style="width:100%;" value="' . esc_attr( $value ) . '" id="cake_author" name="cake_author" placeholder="eg. Jordan Smith" />';
}
function cake_recipe_box_content( $post ) {
  wp_nonce_field( 'cake_recipe_box', 'cake_recipe_box_content_nonce' );
  $value =  get_post_meta(get_the_ID(), '_cake_recipe' , true ) ;
  wp_editor( htmlspecialchars_decode($value), 'mettaabox_ID_stylee', $settings = array('textarea_name'=>'cake_recipe') );
}

// These lines of code save custom fields data to database

function cake_flavor_box_save( $post_id ) {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  return;

  if ( !wp_verify_nonce( $_POST['cake_flavor_box_content_nonce'],'cake_flavor_box') )
  return;

  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
    return;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
    return;
  }
  $cake_flavor = $_POST['cake_flavor'];
  update_post_meta( $post_id, '_cake_flavor', $cake_flavor );
}
add_action( 'save_post', 'cake_flavor_box_save');

function cake_author_box_save( $post_id ) {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  return;

  if ( !wp_verify_nonce( $_POST['cake_author_box_content_nonce'],'cake_author_box') )
  return;

  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
    return;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
    return;
  }
  $cake_flavor = $_POST['cake_author'];
  update_post_meta( $post_id, '_cake_author', $cake_flavor );
}
add_action( 'save_post', 'cake_author_box_save');

function cake_recipe_box_save( $post_id ) {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  return;

  if ( !wp_verify_nonce( $_POST['cake_recipe_box_content_nonce'],'cake_recipe_box') )
  return;

  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
    return;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
    return;
  }
  $cake_flavor = $_POST['cake_recipe'];
  update_post_meta( $post_id, '_cake_recipe', $cake_flavor );
}
add_action( 'save_post', 'cake_recipe_box_save');

add_filter( 'template_include', 'include_template_function', 1 );
function include_template_function( $template_path ) {
    if ( get_post_type() == 'cake' ) {
        if ( is_single() ) {
            // This line of code checks if the file exists in the theme first,
            // otherwise it serves the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-CustomPostType.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/single-CustomPostType.php';
            }
        }
    }
    return $template_path;
}

// This line of code is used for making shortcode to access cake links using shortcode

add_shortcode( 'cakes', 'tcb_sc_custom_posts' );
function tcb_sc_custom_posts( $atts ){
  global $post;
  $default = array(
    'type'      => 'post',
    'post_type' => 'cake',
    'status'    => 'publish',
  );
  $r = shortcode_atts( $default, $atts );
  extract( $r );

  if( empty($post_type) )
    $post_type = $type;

  $post_type_ob = get_post_type_object( $post_type );
  if( !$post_type_ob )
    return '<div class="warning"><p>No such post type <em>' . $post_type . '</em> found.</p></div>';

  $return = '<h3>Cakes</h3>';

  $args = array(
    'post_type'   => $post_type,
    'post_status' => $status,
	'post_id'	  => $postid
  );

  $posts = get_posts( $args );
  if( count($posts) ):

    foreach( $posts as $post ): setup_postdata( $post );
	  $return .= '<ul>';      
	  $return .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
  	  $return .= '</ul>';
    endforeach; wp_reset_postdata();

  else :
    $return .= '<p>No posts found.</p>';
  endif;

  return $return;
}
?>