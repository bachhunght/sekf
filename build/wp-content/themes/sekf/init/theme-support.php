<?php
/*
**
** Enable Function
**
*/


// Pagination action.
add_action( 'wp_ajax_pagination', 'pagination_callback' );
add_action( 'wp_ajax_nopriv_pagination', 'pagination_callback' );
function pagination_callback() {
  $values = $_REQUEST;
  //$content = do_shortcode ('[view_list name="'.$values['name'].'" post_type="news" per_page="2" custom_fields=""]');
  $content = do_shortcode ('[view_list name="'.$values['name'].'" post_type="'.$values['post_type'].'" per_page="'.$values['per_page'].'" cat_id="'.$values['cat_id'].'" custom_fields="'.$values['custom_fields'].'" current_paged="'.$values['paged_index'].'" use_pagination="'.$values['use_pagination'].'" filter_select="0" ]');
  $result = json_encode(array('markup' => $content));
  echo $result;
  wp_die();
}

// Add user role member
add_role(
  'member',
  __('Member', 'theme'),
  array(
    'read' => true,
    'level_0' => true
  )
);

// menu
add_theme_support( 'menus' );
add_action('init', 'sekf_menu');
function sekf_menu() {
  register_nav_menus(array (
    'main' => 'Main Menu',
    'header_top' => 'Header Top Menu',
    'footer' => 'Footer Menu'
  ));
}

// Theme support custom logo
add_action( 'after_setup_theme', 'sekf_setup' );
function sekf_setup() {
  add_theme_support( 'custom-logo', array(
    'flex-width' => true,
  ) );
}

// Theme support custom logo
add_theme_support( 'post-thumbnails' );

add_action( 'admin_init', 'sekf_remove_default_field' );
//add_filter( 'user_can_richedit', 'sekf_remove_default_field' );
/*function sekf_remove_default_field() {
  global $post;
  print_r($post);
  if (($post->post_name == 'home') && ($post->post_type == 'page')) {
    //remove_post_type_support( 'page', 'editor' );
    //echo '<style>#post-body-content #postdivrich {display: none;}</style>';
  }
}*/
function sekf_remove_default_field() {
  // Get the Post ID.
  $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
  if( !isset( $post_id ) ) return;
  // Hide the editor on the page titled 'Homepage'
  $slug = get_post_field( 'post_name', $post_id );
  $homepgname = get_the_title($post_id);
  if($slug == 'home'){
    remove_post_type_support('page', 'editor');
  }
}

// Unset URL from comment form
add_filter( 'comment_form_fields', 'sekf_move_comment_form_below' );
function sekf_move_comment_form_below( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}

// Set per page on each page
add_action( 'pre_get_posts',  'sekf_set_posts_per_page'  );
function sekf_set_posts_per_page( $query ) {
  global $wp_the_query;
  if ( (!is_admin()) && ( $query === $wp_the_query ) && ( $query->is_archive() ) ) {
    $query->set( 'posts_per_page', 1 );
  }
  return $query;
}

add_filter( 'body_class', 'sekf_body_class' );
function sekf_body_class( $classes ) {
  global $post;
  if(is_page()){
    $post_slug = $post->post_name;
    $classes[] = 'page-'.$post_slug;
  }
  return $classes;
}

// wrapper for table in wysiwyg editer
add_filter( 'tiny_mce_before_init', 'fb_mce_before_init' );
function fb_mce_before_init( $settings ) {
  $style_formats = array(
    array(
      'title' => 'Table responsive wrapper',
      'block' => 'div',
      'classes' => 'table-responsive',
      'wrapper' => true
    ),
  );
  $settings['style_formats'] = json_encode( $style_formats );
  return $settings;
}

add_filter('upload_mimes', 'sekf_theme_support_files_type', 1, 1);
function sekf_theme_support_files_type($mime_types){
  $mime_types['svg'] = 'image/svg+xml';
  return $mime_types;
}

/*
**
** Support Widget Layout
**
*/


/* Add Dynamic Siderbar */
if (function_exists('register_sidebar')) {
  // Define Sidebar
  register_sidebar(array(
    'name' => __('Sidebar'),
    'description' => __('Description for this widget-area...'),
    'id' => 'sidebar-right',
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
  // Define Header block
  register_sidebar(array(
    'name' => __('Header block'),
    'description' => __('Description for this widget-area...'),
    'id' => 'header-block',
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
  // Define Footer
  register_sidebar(array(
    'name' => __('Footer block'),
    'description' => __('Description for this widget-area...'),
    'id' => 'footer-block',
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
}

// Theme support get widget ID
function sekf_get_widget_id($widget_instance) {
  if ($widget_instance->number=="__i__"){
    echo "<p><strong>Widget ID is</strong>: Pls save the widget first!</p>"   ;
  } else {
    echo "<p><strong>Widget ID is: </strong>" .$widget_instance->id. "</p>";
  }
}
add_action('in_widget_form', 'sekf_get_widget_id');

// Sidebar widget arena
add_action( 'widgets_init', 'sekf_create_sidebar_Widget' );
function sekf_create_sidebar_Widget() {
  register_widget('sidebar_Widget');
}

class sidebar_Widget extends WP_Widget {
  public function __construct() {
    $widget_ops = array(
      'classname' => 'sidebar_widget',
      'description' => __( 'Sidebar widget.' ),
      'customize_selective_refresh' => true,
    );
    $control_ops = array( 'width' => 400, 'height' => 350 );
    parent::__construct( 'sidebar_widget', __( 'Sidebar Widget' ), $widget_ops, $control_ops );
  }

  public function widget( $args, $instance ) {
    $title    = apply_filters( 'widget_title', $instance['title'] );
    echo $args['before_widget'];
    if ( $title ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }
    echo $args['after_widget'];
  }

  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }

  function form( $instance ) {
    $title      = esc_attr( $instance['title'] );
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
    <?php
  }
}

// Header widget arena
add_action( 'widgets_init', 'sekf_create_header_Widget' );
function sekf_create_header_Widget() {
  register_widget('header_Widget');
}

class header_Widget extends WP_Widget {
  public function __construct() {
    $widget_ops = array(
      'classname' => 'header_widget',
      'description' => __( 'Custom widget.' ),
      'customize_selective_refresh' => true,
    );
    $control_ops = array( 'width' => 400, 'height' => 350 );
    parent::__construct( 'header_widget', __( 'Header Widget' ), $widget_ops, $control_ops );
  }

  public function widget( $args, $instance ) {
    $title    = apply_filters( 'widget_title', $instance['title'] );
    echo $args['before_widget'];
    if ( $title ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }
    echo $args['after_widget'];
  }

  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }

  function form( $instance ) {
    $title      = esc_attr( $instance['title'] );
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
    <?php
  }
}

// Footer widget arena
add_action( 'widgets_init', 'sekf_create_footer_Widget' );
function sekf_create_footer_Widget() {
  register_widget('footer_Widget');
}

class footer_Widget extends WP_Widget {
  public function __construct() {
    $widget_ops = array(
      'classname' => 'footer_Widget',
      'description' => __( 'Custom widget.' ),
      'customize_selective_refresh' => true,
    );
    $control_ops = array( 'width' => 400, 'height' => 350 );
    parent::__construct( 'footer_Widget', __( 'Footer Widget' ), $widget_ops, $control_ops );
  }

  public function widget( $args, $instance ) {
    $title    = apply_filters( 'widget_title', $instance['title'] );
    echo $args['before_widget'];
    if ( $title ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }
    echo $args['after_widget'];
  }

  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }

  function form( $instance ) {
    $title      = esc_attr( $instance['title'] );
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
    <?php
  }
}

