<?php
/*
 *
 *
 * Registor Theme option
 *
 *
 */

add_action( 'cmb2_admin_init', 'sekf_image_default' );
function sekf_image_default() {

 $cmb = new_cmb2_box( array(
    'id'      => 'wiki_test_image',
    'type'    => 'file',
    'title'         => __( 'ok test', 'cmb2' ),
    'object_types'  => array('post', 'page'), // Post type or any post type use: ct_list_posttype()
  ) );

  $cmb->add_field( array(
    'name'    => 'Test File',
    'desc'    => 'Upload an image or enter an URL.',
    'id'      => 'wiki_test_image',
    'type'    => 'file',
    // Optional:
    'options' => array(
        'url' => true, // Hide the text input for the url
    ),

    // query_args are passed to wp.media's library query.
    'query_args' => array(
        'type' => 'application/pdf', // Make library only display PDFs.
    ),
  ) );
}

