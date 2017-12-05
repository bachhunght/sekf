<?php
/**
 * Search results page
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */
global $query_string;

$query_args = explode("&", $query_string);
$search_query = array();

if( strlen($query_string) > 0 ) {
  foreach($query_args as $key => $string) {
    $query_split = explode("=", $string);
    $search_query[$query_split[0]] = urldecode($query_split[1]);
  }
}

$context = Timber::get_context();
$post = Timber::get_posts($search_query);
$context['title'] = 'Sökresultat för: '. get_search_query();
$context['posts'] = $post;
 $context['pagination'] = Timber::get_pagination();

Timber::render( 'search.twig', $context );
