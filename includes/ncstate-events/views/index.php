<?php

        global $wp_query;

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $subcalendar = (get_query_var('term')) ? get_query_var('term') : false;


        $arqs = array(
                'post_type'       => 'events',
                'subcalendar' 	  => $subcalendar,
                'meta_key'        => 'start_time',
                'meta_query' => array(
                    array(
                        'key' => 'start_time',
                        'value' => current_time('timestamp'),
                        'compare' => '>='
                    )
                ),
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'posts_per_page' => 5,
                'paged' => $paged,
        );
        $wp_query = new WP_Query($arqs);

?>

<?php  get_header(); ?>

<body>
<?php include get_template_directory() . '/masthead.php'; ?>

<div id="main-content" role="main">

<!-- Remove for custom HP -->
<section id="events-index">
  <div class="container">
    <div class="index-main row">
    	<h1 class="section-head"><?php echo (single_cat_title('',false)) ? single_cat_title('', false) : 'Events';?></h1>
        <div class="events-list">
            <?php
                if ( $wp_query->have_posts() ) :
                    while( $wp_query->have_posts() ) : $wp_query->the_post();
                        $id = get_the_ID();
                        $meta = get_post_meta($id);
                        $date = $meta['start_time'][0];
                        setup_postdata($event);
                        echo '<a class="event-block" href="' . get_permalink($id) . '">';
                            echo '<div class="event-date red-bg"><time>' . date('M', $date) . '<span>' . date('j', $date) . '</span></time></div>';
                            echo '<div class="event-details">';
								if(date('g:i a', $date)=="12:00 am"):
									echo '<p>' . date('l', $date) . '</p>';
								else:
									echo '<p>' . date('l | g:i a', $date) . '</p>';
								endif;
                                echo '<h2>' . get_the_title() . '</h2>';
                                echo '<p><b>' . $meta['location'][0] . '</b></p>';
                                echo '<p>' . get_the_excerpt() . '</p>';
                            echo '</div>';
                        echo '</a>';
                    endwhile;
                    echo "<div class=\"events-back pull-left\">" . get_previous_posts_link( '<span class="nowrap"><span class="glyphicon glyphicon-roman-arrow"></span>Back</span>' ) . "</div>";
                    echo "<div class=\"more-events pull-right\">" . get_next_posts_link( 'More <span class="nowrap">Events<span class="glyphicon glyphicon-roman-arrow"></span></span>', $wp_query->max_num_pages ) . "</div>";
                    echo "<div class=\"clearfix\"></div>";
                else :
                    echo "<p>Sorry, no posts matched your criteria.</p>";
                endif;
            ?>
        </div>
        <?php if ( $wp_query->have_posts() ) : ?>
        <div class="events-index-sidebar spotlight-box">
        <?php if (get_field('index_sidebar_type', 'option') == 'event-spotlight') : ?>
            <?php if (get_field('box_heading', 'option')) : ?>
                <h2 class="spotlight-group_heading"><?php the_field('index_sidebar_box_heading', 'option'); ?></h2>
            <?php endif; ?>
            <?php if (get_field('index_sidebar_image', 'option')) : ?>
                <?php echo get_retina_images(get_field('index_sidebar_image', 'option'), array(345, 360, 220, 768)); ?>
            <?php endif; ?>
            <?php if (get_field('index_sidebar_main_heading', 'option')) : ?>
                <h3 class="spotlight-main_heading"><?php the_field('index_sidebar_main_heading', 'option'); ?></h3>
            <?php endif; ?>
            <?php if (get_field('index_sidebar_text', 'option')) : ?>
                <div class="spotlight-txt">
                    <?php the_field('index_sidebar_text', 'option'); ?>
                </div>
            <?php endif; ?>
            <?php if (get_field('index_sidebar_call_to_action', 'option') && get_field('index_sidebar_url', 'option')) : ?>
                <a href="<?php the_field('index_sidebar_url', 'option'); ?>" class="action-link"><?php echo append_arrow(get_field('index_sidebar_call_to_action', 'option'), 'bold-arrow'); ?></a>
            <?php endif; ?>
        <?php else : ?>
            <?php 
                    if (get_field('lists', 'option')) :
                        while ( have_rows('lists', 'option') ) : the_row();

                        if( get_row_layout() == 'sub-calendars' ):

                            echo "<h2 class=\"spotlight-group_heading\">" . get_sub_field('heading') . "</h2>";
                            echo "<ul class=\"spotlight-list\">";
                            $args = array(
                                'title_li'           => '',
                                'taxonomy'           => 'subcalendar',
                                'depth'              => 1
                            );
                            wp_list_categories( $args );
                            echo "</ul>";

                        elseif( get_row_layout() == 'custom_list' ):

                            echo "<h2 class=\"spotlight-group_heading\">" . get_sub_field('heading') . "</h2>";
                            echo "<ul class=\"spotlight-list\">"; 
                            while (have_rows('content')) : the_row();
                                if ( get_sub_field('text') && get_sub_field('url') ) :
                                    echo "<li><a href=\"" . get_sub_field('url') . "\">" . get_sub_field('text') . "</a></li>";
                                endif;
                            endwhile;
                            echo "</ul>";

                        endif;

                        endwhile;
                    else : 

                        $arqs = array(
                                'post_type'       => 'events',
                                'meta_key'        => 'start_time',
                                'meta_query' => array(
                                    array(
                                        'key' => 'start_time',
                                        'value' => current_time('timestamp'),
                                        'compare' => '>='
                                    )
                                ),
                                'orderby' => 'meta_value_num',
                                'order' => 'ASC',
                                'posts_per_page' => 1
                        );
                        $event_query = new WP_Query($arqs);

                        if ( $event_query->have_posts() ) :
                            $next_event = $event_query->the_post();
                            $id = get_the_ID();
                            $meta = get_post_meta($id);
                            $date = $meta['start_time'][0];
                            $end_date = $meta['end_time'][0];
                            setup_postdata($event);
            ?>
                        <h2 class="spotlight-group_heading">Next Event</h2>
                        <h3 class="spotlight-main_heading"><?php the_title(); ?></h3>
                        <div class="spotlight-txt">
                            <?php 
                                echo date('l, F j', $date) . "<br/>";
                                if(date('g:i a', $date) !== "12:00 am" && (date('mdY', $date) == date('mdY', $end_date))):
                                    echo date('g:i a', $date) . ' - ' . date('g:i a', $end_date) . '<br/>';
                                endif;
                                echo $meta['location'][0];
                            ?>
                        </div>
                        <a href="<?php echo get_permalink($id); ?>" class="action-link"><?php echo append_arrow('Learn More', 'bold-arrow'); ?></a>
            <?php
                    endif;
                    endif;
            ?>
        <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
  </div>
</section>
<!-- End remove -->

</div>

<?php get_footer(); ?>
