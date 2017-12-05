<?php
add_action( 'cmb2_admin_init', 'sekf_sidebar_post_metaboxes' );
function sekf_sidebar_post_metaboxes() {

  $prefix = '_cmb2_';

  $cmb = new_cmb2_box( array(
    'id'            => 'post_options',
    'title'         => __( 'Login option', 'cmb2' ),
    'object_types'  => array('post', 'page'), // Post type or any post type use: ct_list_posttype()
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true,
  ) );

  // // Sidebar Left
  // $cmb->add_field( array(
  //   'name'             => __( 'Left Sidebar Menus', 'cmb2' ),
  //   'desc'             => __( 'Choose Menus for Left Sidebar on this page', 'cmb2' ),
  //   'id'               => $prefix . 'sidebar_menu',
  //   'type'             => 'select',
  //   'show_option_none' => true,
  //   'options'          => sekf_list_nav_menus(),
  // ) );

   // login required
  $cmb->add_field( array(
    'name'       => __( ' login required', 'cmb2' ),
    'desc'       => __( 'Check it if you want users must log in to view the content', 'cmb2' ),
    'id'         => $prefix . 'roleloginrequired',
    'type'       => 'checkbox',
  ) );
}

function framework_post($name = '') {
  global $post;
  $value = get_post_meta( $post->ID, '_cmb2_' . $name, true );
  return $value;
}
