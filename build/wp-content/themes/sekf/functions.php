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
    wp_register_script('lib-masonry', get_stylesheet_directory_uri() . '/dist/js/libs/masonry.pkgd.min.js', array('jquery'), FALSE, '4.1.1', TRUE);
    wp_enqueue_script('lib-masonry');

    wp_register_script('lib-slick', get_stylesheet_directory_uri() . '/dist/js/libs/slick.min.js', array('jquery'), FALSE, '1.6.0', TRUE);
    wp_enqueue_script('lib-slick');

    wp_register_script('Bootstrap', get_stylesheet_directory_uri() . '/dist/js/libs/bootstrap.min.js', array('jquery'), FALSE, '3.0.3', TRUE);
    wp_enqueue_script('Bootstrap');

    wp_register_script('lib-matchHeight', get_stylesheet_directory_uri() . '/dist/js/libs/jquery.matchHeight-min.js', array('jquery'), FALSE, '0.7.0', TRUE);
    wp_enqueue_script('lib-matchHeight');

    wp_register_script('lib-hyphenator', get_stylesheet_directory_uri() . '/dist/js/libs/Hyphenator.js', array('jquery'),  FALSE, '2.1.5', TRUE);
    wp_enqueue_script('lib-hyphenator');

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


//apply_filters( 'wpcf7_messages', $messages )
function custom_messages($messages) {
  $messages = array(
    'mail_sent_ok' => array(
      'description'
        => __( "Sender's message was sent successfully", 'contact-form-7' ),
      'default'
        => __( "Tack för ditt meddelande, det har skickats.", 'contact-form-7' )
    ),

    'mail_sent_ng' => array(
      'description'
        => __( "Sender's message failed to send", 'contact-form-7' ),
      'default'
        => __( "Det uppstod ett problem när ditt meddelande skulle skickas. Var god försök igen senare.", 'contact-form-7' )
    ),

    'validation_error' => array(
      'description'
        => __( "Validation errors occurred", 'contact-form-7' ),
      'default'
        => __( "Ett eller flera fält har ett fel. Var god rätta till dem och försök igen.", 'contact-form-7' )
    ),

    'spam' => array(
      'description'
        => __( "Submission was referred to as spam", 'contact-form-7' ),
      'default'
        => __( "Det uppstod ett problem när ditt meddelande skulle skickas. Var god försök igen senare.", 'contact-form-7' )
    ),

    'accept_terms' => array(
      'description'
        => __( "There are terms that the sender must accept", 'contact-form-7' ),
      'default'
        => __( "Du måste acceptera villkoren innan du kan skicka ditt meddelande.", 'contact-form-7' )
    ),

    'invalid_required' => array(
      'description'
        => __( "There is a field that the sender must fill in", 'contact-form-7' ),
      'default'
        => __( "Fältet är obligatoriskt.", 'contact-form-7' )
    ),

    'invalid_too_long' => array(
      'description'
        => __( "There is a field with input that is longer than the maximum allowed length", 'contact-form-7' ),
      'default'
        => __( "Fältet är för långt.", 'contact-form-7' )
    ),

    'invalid_too_short' => array(
      'description'
        => __( "There is a field with input that is shorter than the minimum allowed length", 'contact-form-7' ),
      'default'
        => __( "Fältet är för kort.", 'contact-form-7' )
    ),

    'invalid_date' => array(
      'description' => __( "Date format that the sender entered is invalid", 'contact-form-7' ),
      'default' => __( "Datumformatet är inkorrekt.", 'contact-form-7' )
    ),

    'date_too_early' => array(
      'description' => __( "Date is earlier than minimum limit", 'contact-form-7' ),
      'default' => __( "Datumet är före det tidigaste tillåtna.", 'contact-form-7' )
    ),

    'date_too_late' => array(
      'description' => __( "Date is later than maximum limit", 'contact-form-7' ),
      'default' => __( "Datum före det senaste är ", 'contact-form-7' )
    ),
        'upload_failed' => array(
      'description' => __( "Uploading a file fails for any reason", 'contact-form-7' ),
      'default' => __( "Det uppstod ett problem när du försökte ladda upp filen.", 'contact-form-7' )
    ),

    'upload_file_type_invalid' => array(
      'description' => __( "Uploaded file is not allowed for file type", 'contact-form-7' ),
      'default' => __( "Det är inte tillåtet att ladda upp filer i detta format.", 'contact-form-7' )
    ),

    'upload_file_too_large' => array(
      'description' => __( "Uploaded file is too large", 'contact-form-7' ),
      'default' => __( "Filen är för stor.", 'contact-form-7' )
    ),

    'upload_failed_php_error' => array(
      'description' => __( "Uploading a file fails for PHP error", 'contact-form-7' ),
      'default' => __( "Ett fel uppstod när du försökte ladda upp filen.", 'contact-form-7' )
    ),

      'invalid_number' => array(
      'description' => __( "Number format that the sender entered is invalid", 'contact-form-7' ),
      'default' => __( "Nummerformatet är inkorrekt", 'contact-form-7' )
    ),

    'number_too_small' => array(
      'description' => __( "Number is smaller than minimum limit", 'contact-form-7' ),
      'default' => __( "Siffran är mindre än vad som är tillåtet", 'contact-form-7' )
    ),

    'number_too_large' => array(
      'description' => __( "Number is larger than maximum limit", 'contact-form-7' ),
      'default' => __( "Siffran är större än vad som är tillåtet", 'contact-form-7' )
    ),

    'quiz_answer_not_correct' => array(
    'description' => __( "Sender doesn't enter the correct answer to the quiz", 'contact-form-7' ),
    'default' => __( "Svaret är inkorrekt.", 'contact-form-7' )
    ),

    'invalid_email' => array(
      'description' => __( "Email address that the sender entered is invalid", 'contact-form-7' ),
      'default' => __( "E-postadressen är i fel format.", 'contact-form-7' )
    ),

    'invalid_url' => array(
      'description' => __( "URL that the sender entered is invalid", 'contact-form-7' ),
      'default' => __( "URL:en är inkorrekt.", 'contact-form-7' )
    ),

    'invalid_tel' => array(
      'description' => __( "Telephone number that the sender entered is invalid", 'contact-form-7' ),
      'default' => __( "Telefonnummret är i fel format.", 'contact-form-7' )
    )
  );
 return $messages;
}

add_filter('wpcf7_messages', 'custom_messages');


/*
   Debug preview with custom fields
*/

add_filter('_wp_post_revision_fields', 'add_field_debug_preview');
function add_field_debug_preview($fields){
   $fields["debug_preview"] = "debug_preview";
   return $fields;
}

add_action( 'edit_form_after_title', 'add_input_debug_preview' );
function add_input_debug_preview() {
   echo '<input type="hidden" name="debug_preview" value="debug_preview">';
}
