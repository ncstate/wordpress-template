<?php
ncsu_default_template_reset();

function ncsu_default_template_reset() {
    $args = array(
                'post_type' => 'page',
                'meta_query' => array(
                        array(
                                'key' => '_wp_page_template',
                                'value' => array('page.php', 'page-text.php', 'default'),
                                'compare' => 'IN'
                        )
                ),
                'posts_per_page' => -1
            );

    $default_pages = new WP_Query( $args );

    if ( $default_pages->have_posts() ) {
        while ( $default_pages->have_posts() ) {
            $default_pages->the_post();
            update_post_meta( get_the_ID(), '_wp_page_template', 'page-nav.php' );
        }
    }
}

?>