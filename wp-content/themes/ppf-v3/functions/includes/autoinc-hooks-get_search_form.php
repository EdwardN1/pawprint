<?php
function html5_search_form( $form ) {
    $form = '<form role="search" method="get" action="' . home_url( '/' ) . '" >
    <label class="screen-reader-text" for="s">' . __('',  'domain') . '</label>
     <input type="search" value="' . get_search_query() . '" name="s" placeholder="Search product, resource or activity" />
     <input type="submit" value="'. esc_attr__('Go', 'domain') .'" />
     </form>';
    return $form;
}

add_filter( 'get_search_form', 'html5_search_form' );