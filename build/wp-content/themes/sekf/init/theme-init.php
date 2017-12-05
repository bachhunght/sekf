<?php
$timber = new \Timber\Timber();

use Timber\Timber;
use Timber\Menu;

// load the theme's framework
require_once dirname( __FILE__ ) . '/theme-support.php';

// Get custom function template with Timber
Timber::$dirname = array('templates', 'templates/blocks', 'templates/shortcode', 'templates/pages', 'templates/layouts', 'templates/views');

/**
 *
 * View Related Post by Taxonomy.
 * @param type $custom_cat String slug of vocabulary.
 * @param type $showpost Int number post want show.
 *
 * @return type $loop_custom Object for post.
 *
 */
function related($custom_cat, $showpost = -1) {
  global $post;
  $argss = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'ids');
  $terms = wp_get_post_terms( $post->ID, $custom_cat, $argss );
  $myposts = array(
    'showposts' => $showpost,
    'post_type' => 'any',
    'post__not_in' => array($post->ID),
    'tax_query' => array(
      array(
      'taxonomy' => $custom_cat,
      'field' => 'term_id',
      'terms' => $terms
      )
    )
  );
  $loop_custom = Timber::get_posts($myposts);
  return $loop_custom;
}

/**
 *
 * Disable Dynamic Sidebar.
 * @param type $name String slug of Dynamic Sidebar.
 *
 * @return Dynamic Sidebar.
 *
 */
function sidebar($name) {
  if ( is_active_sidebar( $name ) ) {
    dynamic_sidebar($name);
  }
  return;
}

/**
 *
 * Disable Sidebar Active.
 * @param type $name String slug of Dynamic Sidebar.
 *
 * @return Dynamic Sidebar Active.
 *
 */
function sidebar_active($name) {
  $sidebar_active = is_active_sidebar( $name );
  return $sidebar_active;
}

/**
 *
 * Disable shortcode.
 * @param type $name String shortcode form.
 *
 * @return Shortcode.
 *
 */
function shortcode($name) {
  echo do_shortcode($name);
  return;
}

/**
 *
 * Disable shortcode.
 * @param type $id Int post ID.
 *
 * @return type $post_link String URL for post.
 *
 */
function post_link($id) {
  global $post;
  $post_link = get_permalink( $id );
  return $post_link;
}

/**
 *
 * ACF in Widget.
 * @param type $name String Slug of ACF field.
 * @param type $widgetid String Slug of Widget.
 *
 * @return type $acffield String, Array Value of ACF field in Widget.
 *
 */
function acfwidget($name, $widgetid) {
  if (get_field($name, 'widget_'.$widgetid)) {
    $afcfield = get_field($name, 'widget_'.$widgetid);
    //print_r($afcfield);

    if ( !empty( $afcfield ) ) {
      foreach ($afcfield as $field) {
        $layout = $field['acf_fc_layout'];

        try {
          Timber::render($layout . '.twig', $field);
        } catch (Exception $e) {
          echo 'Could not find a twig file for layout type: ' . $layout;
        }
      }
    }
  }
  return;
}

/**
 *
 * ACF Object Return.
 * @param type $name String Slug of ACF field.
 * @param type $object String Slug of Widget.
 *
 * @return Object of ACF fields.
 *
 */
function acfobject($name, $object) {
  $field = get_field_object($name);
  $field_object = $field[$object];
  if (is_array($field_object)) {
    return $field_object;
  } else {
    echo $field_object;
  }
  return;
}

/**
 *
 * View List Taxonomy.
 * @param type $tax String Slug of Taxonomy.
 *
 * @return HTML Template for all term of taxonomy.
 *
 */
function taxvalue($tax) {
  $args = array(
    'parent' => 0,
    'orderby' => 'slug',
    'hide_empty' => false
  );

  $terms = get_terms( $tax, $args);
  if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    echo '<ul class="listcat listcat-'.$tax.'">';
    foreach ( $terms as $term ) {
      $subterms1 = get_terms($tax, array('parent' => $term->term_id, 'orderby' => 'slug', 'hide_empty' => false));

      if (sizeof($subterms1) > 0) {
        echo '<li class="listcat-item"><a href="'.esc_url( get_term_link( $term ) ).'">' . $term->name . '</a>';

        // sub term 1
        echo '<ul class="subterm">';
          foreach ($subterms1 as $term) {
            $subterms2 = get_terms($tax, array('parent' => $term->term_id, 'orderby' => 'slug', 'hide_empty' => false));

            if (sizeof($subterms2) > 0) {
              echo '<li class="listcat-item has-subterm"><a href="'.esc_url( get_term_link( $term ) ).'">' . $term->name . '</a>';

              // sub term 2
              echo '<ul class="subterm">';
              foreach ($subterms2 as $term) {
                echo '<li class="listcat-item"><a href="'.esc_url( get_term_link( $term ) ).'">' . $term->name . '</a></li>';
              }
              echo '</ul></li>';
            } else {
              echo '<li class="listcat-item"><a href="'.esc_url( get_term_link( $term ) ).'">' . $term->name . '</a></li>';
            }
          }
        echo '</ul></li>';
      } else {
        echo '<li class="listcat-item"><a href="'.esc_url( get_term_link( $term ) ).'">' . $term->name . '</a></li>';
      }
    }
    echo '</ul>';
  }
}

/**
 *
 * Get Term name.
 * @param type $slug String Slug of Term.
 * @param type $tax String Slug of Taxonomy.
 *
 * @return type $term_name String Name of the term.
 *
 */
function get_term_name($slug, $tax){
  $term = get_term_by('slug', $slug, $tax);
  $term_name = array(
    array(
      'name' => $term->name,
      'slug' => $term->slug,
      'link' => esc_url( get_term_link( $term ) ),
    )
  );
  return $term_name;
}

/**
 *
 * Get Avatar Author.
 * @param type $size String (150x150) Size of Image.
 *
 * @return type $avatar String URL for Avatar Author.
 *
 */
function avatar_author($size = '') {
  $avatar = get_avatar( get_the_author_meta( 'ID' ), $size );
  return $avatar;
}

/**
 *
 * ACF Flexible Content Fielld.
 * @param type $name String Slud ACF flexible_content field.
 *
 * @return Array all sub_fields in flexible_content field.
 *
 */
function flexible_content($name) {
  $fc_type = array();

  global $post;
  $fc = get_field( $name, $post->ID );
  $fc_ob = get_field_object( $name, $post->ID );

  //print_r($fc);
  //print_r($fc_ob);

  if ( !empty( $fc ) ) {
    foreach ($fc as $field) {
      $layout = $field['acf_fc_layout'];
      $fc_type[$layout] = array();

      if ( $field['acf_fc_layout'] == 'box_views_group' ) {
        $fc_sub = $field['views_shortcode_group']['view_component'];
        foreach ($fc_sub as $field_sub) {
          $layout_sub = $field_sub['acf_fc_layout'];

          try {
            Timber::render($layout_sub . '.twig', $field_sub);
          } catch (Exception $e) {
            echo 'Could not find a twig file for layout type: ' . $layout_sub;
          }
        }
      } else {
        try {
          Timber::render($layout . '.twig', $field);
        } catch (Exception $e) {
          echo 'Could not find a twig file for layout type: ' . $layout;
        }
      }
    }
  }

  return;
}

/**
 *
 * Preg Match URL.
 * @param type $field String URL Youtube, Vimeo.
 *
 * @return type $src.
 *
 */
function preg_match_url($field, $extend) {
  preg_match('/src="(.+?)"/', $field, $matches);
  $full_src = $matches[1];
  $src = explode("?", $full_src);

  if($extend) {
    $src = $src[0] . $extend;
  } else {
    $src = $src[0];
  }
  return $src;
}

/**
 *
 * Get ID from oEmbed.
 * @param type $url String HTML Iframe video.
 *
 * @return type $result String ID video from frame.
 *
 */
function get_id_embed($url) {
  $video_id = preg_match_url($url);
  $pattern =
        '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
        ;
  $result = preg_match($pattern, $video_id, $matches);
  if ($result) {
    return $matches[1];
  }
  return false;
}

/**
 *
 * Get ID from Youtube URL.
 * @param type $url String Youtube URL.
 *
 * @return type $result String ID from Youtube URL.
 *
 */
function get_id_youtube($url) {
  $video_id = $url;
  $pattern =
        '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
        ;
  $result = preg_match($pattern, $video_id, $matches);
  if ($result) {
    return $matches[1];
  }
  return false;
}

/**
 *
 * Add data value into Timber.
 * @param type $str String Slug for taxonomy of post.
 * @param type $arr Array Terms array.
 *
 * @return type $str String if $str in array $arr then return $str.
 *
 */
function twig_in_array($str, $arr) {
  if( in_array($str, $arr) ){
    return $str;
  }
}

/**
 *
 * Add data value into Timber.
 *
 * @return type $data String, Object, Array Global value in Timber template.
 *
 */
add_filter('timber_context', 'sekf_twig_data');
function sekf_twig_data($data){
  // Theme setting
  $custom_logo_id = get_theme_mod( 'custom_logo' );
  $custom_logo_attachment = wp_get_attachment_image_src( $custom_logo_id , 'full' );
  $custom_logo = $custom_logo_attachment[0];

  $logo = get_template_directory_uri().'/dist/images/logo.svg';
  $favicon = get_template_directory_uri().'/dist/images/favicon.ico';

  $data['site_logo'] = new TimberImage($logo);
  $data['custom_logo'] = new TimberImage($custom_logo);
  $data['site_favicon'] = new TimberImage($favicon);

  //$data['flexible_content'] = TimberHelper::function_wrapper( 'flexible_content' );
  //$data['preg_match_url'] = TimberHelper::function_wrapper( 'preg_match_url' );
  //$data['get_id_embed'] = TimberHelper::function_wrapper( 'get_id_embed' );
  //$data['get_id_youtube'] = TimberHelper::function_wrapper( 'get_id_youtube' );
  //$data['related'] = TimberHelper::function_wrapper( 'related' );
  //$data['sidebar'] = TimberHelper::function_wrapper( 'sidebar' );
  //$data['sidebar_active'] = TimberHelper::function_wrapper( 'sidebar_active' );
  //$data['shortcode'] = TimberHelper::function_wrapper( 'shortcode' );
  //$data['acfwidget'] = TimberHelper::function_wrapper( 'acfwidget' );
  //$data['acfobject_field'] = TimberHelper::function_wrapper( 'acfobject_field' );
  //$data['acfobject'] = TimberHelper::function_wrapper( 'acfobject' );
  //$data['customtax'] = TimberHelper::function_wrapper( 'customtax' );
  //$data['get_term_name'] = TimberHelper::function_wrapper( 'get_term_name' );
  //$data['avatar_author'] = TimberHelper::function_wrapper( 'avatar_author' );
  //$data['twig_in_array'] = TimberHelper::function_wrapper( 'twig_in_array' );
  //$data['post_link'] = TimberHelper::function_wrapper( 'post_link' );
  // $data['post_link1'] = TimberHelper::function_wrapper( 'post_link1' );

  $data['menu']['main'] = new TimberMenu('main');
  $data['menu']['header_top'] = new TimberMenu('header_top');
  $data['menu']['footer'] = new TimberMenu('footer');

  return $data;
}
