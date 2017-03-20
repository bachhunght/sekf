<?php
global $paged;
if (!isset($paged) || !$paged){
    $paged = 1;
}

$context = Timber::get_context();
$count = 16;
$context['count'] = $count;
$context['paged'] = $paged;
$taxonomy = new TimberTerm();


$args = array(
  'post_type' => 'any',
  'tax_query' => array(
    array(
      'taxonomy' => $taxonomy->taxonomy,
      'field' => 'slug',
      'terms' => $taxonomy->slug,
    )
  ),
  'posts_per_page' => $count,
  'paged' => $paged
);

$context['title'] = 'Archive';
if ( is_day() ) {
  $context['title'] = 'Archive: '.get_the_date( 'D M Y' );
} else if ( is_month() ) {
  $context['title'] = 'Archive: '.get_the_date( 'M Y' );
} else if ( is_year() ) {
  $context['title'] = 'Archive: '.get_the_date( 'Y' );
} else if ( is_tag() ) {
  $context['title'] = single_tag_title( '', false );
} else if ( is_category() ) {
  $context['title'] = single_cat_title( '', false );
} else if ( is_post_type_archive() ) {
  $context['title'] = post_type_archive_title( '', false );
}

query_posts($args);
$context['term'] = $taxonomy;
$context['pagination'] = Timber::get_pagination();

Timber::render('event.twig', $context);

