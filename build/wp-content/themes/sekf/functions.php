<?php
/*
 *  Author: Framework | @Framework
 *  URL: wordfly.com | @wordfly
 *  Custom functions, support, custom post types and more.
 */

// Theme setting
require_once('init/theme-init.php');
require_once('init/theme-shortcode.php');
require_once('init/options/option.php');

/* Custom for theme */
//echo get_stylesheet_directory_uri();

if(!is_admin()) {
  // Add scripts
  function sekf_libs_scripts() {
    wp_register_script('lib-masonry', get_stylesheet_directory_uri() . '/dist/js/libs/masonry.min.js', array('jquery'), FALSE, '3.1.4', TRUE);
    wp_enqueue_script('lib-masonry');

    wp_register_script('lib-slick', get_stylesheet_directory_uri() . '/dist/js/libs/slick.min.js', array('jquery'), FALSE, '1.6.0', TRUE);
    wp_enqueue_script('lib-slick');

    wp_register_script('Bootstrap', get_stylesheet_directory_uri() . '/dist/js/libs/bootstrap.min.js', array('jquery'), FALSE, '3.0.3', TRUE);
    wp_enqueue_script('Bootstrap');

    wp_register_script('lib-matchHeight', get_stylesheet_directory_uri() . '/dist/js/libs/jquery.matchHeight-min.js', array('jquery'), FALSE, '0.7.0', TRUE);
    wp_enqueue_script('lib-matchHeight');

    wp_register_script('lib-fancybox', get_stylesheet_directory_uri() . '/dist/js/libs/jquery.fancybox.pack.js', array('jquery'),  FALSE, '2.1.5', TRUE);
    wp_enqueue_script('lib-fancybox');

    wp_register_script('script', get_stylesheet_directory_uri() . '/dist/js/script.js', FALSE, '1.0.0', TRUE);
    wp_localize_script( 'script', 'paginationAjax', array( 'ajaxurl' => admin_url('admin-ajax.php' )));
    wp_enqueue_script('script');
  }
  add_action('wp_print_scripts', 'sekf_libs_scripts');

  // Add stylesheet
  function sekf_styles() {
    wp_register_style('slick', get_stylesheet_directory_uri() . '/dist/css/slick.css', array(), '1.6.0', 'all');
    wp_enqueue_style('slick');

    wp_register_style('slick-theme', get_stylesheet_directory_uri() . '/dist/css/slick-theme.css', array(), '1.6.0', 'all');
    wp_enqueue_style('slick-theme');

    wp_register_style('font-awesome', get_stylesheet_directory_uri() . '/dist/css/font-awesome.min.css', array(), '4.3.0', 'all');
    wp_enqueue_style('font-awesome');

    wp_register_style('bootstrap', get_stylesheet_directory_uri() . '/dist/css/bootstrap.min.css', array(), '3.0.3', 'all');
    wp_enqueue_style('bootstrap');

    wp_register_style('bootstrap-theme', get_stylesheet_directory_uri() . '/dist/css/bootstrap-theme.min.css', array(), '3.0.3', 'all');
    wp_enqueue_style('bootstrap-theme');

    $styles = get_stylesheet_directory_uri() . '/dist/css/styles.css';
    wp_register_style('theme-style', $styles, array(), '1.0', 'all');
    wp_enqueue_style('theme-style');
  }
  add_action('wp_enqueue_scripts', 'sekf_styles');
}

// Add admin script
function sekf_admin_scripts() {
  wp_register_script('lib-moment', get_stylesheet_directory_uri() . '/dist/js/admin-libs/moment.js', array('jquery'), '2.13.0');
  wp_enqueue_script('lib-moment');

  wp_register_script('lib-datetimepicker', get_stylesheet_directory_uri() . '/dist/js/admin-libs/bootstrap-datetimepicker.min.js', array('jquery'), '4.17.37');
  wp_enqueue_script('lib-datetimepicker');

  wp_register_script('admin-script', get_stylesheet_directory_uri() . '/dist/js/admin-script.js', array('jquery'), '1.0.0');
  wp_enqueue_script('admin-script');
}
add_action('admin_init', 'sekf_admin_scripts');

// Add admin script
function sekf_admin_styles() {
  wp_register_style('admin-style', get_stylesheet_directory_uri() . '/dist/css/admin.css', array(), '1.0', 'all');
  wp_enqueue_style('admin-style');
}
add_action('admin_init', 'sekf_admin_styles');
