<?php
     // Create Cross Section short code
    add_shortcode( 'cross_section', 'cross_section_shortcode' );
    function cross_section_shortcode( $atts, $content = "" ){
        include "includes/layout.php";
        
        extract (shortcode_atts ( array (
            'img_src' => '',
            'img_pos' => 'left',
            'link' => false,
            'link_txt' => '',
            'link_url' => '',
            'color' => 'green'
        ), $atts ) );
        
        $id = "cross_section_" . rand(0,1000000);

        $image = ncsu_get_img_object_from_url( $img_src );

        $output = "";

        if ( $link && $link_url ):
            $output .= "<a href=\"" . $link_url . "\" target=\"_blank\" id=\"" . $id . "\">";
        endif;
            $output .= "<div class='cross-section " . $color . "-bg'>";
                if ( $img_pos == 'left' && $image):
                $output .= "<picture class='cross-section-img'>";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-lg-desktop'] . "\" media=\"(min-width: " . $lg_breakpoint . ")\">";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-desktop'] . "\" media=\"(min-width: " . $md_breakpoint . ")\">";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-sm-desktop'] . "\" media=\"(min-width: " . $sm_breakpoint . ")\">";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-tablet'] . "\" media=\"(min-width: " . $xs_breakpoint . ")\">";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-phone'] . "\">";
                    $output .= "<img src=\"" . $image['sizes']['callout-desktop'] . "\" class=\"img-responsive\" alt=\"" . $image['alt'] . "\" />";
                $output .= "</picture>";
                endif;
                $output .= "<div class='cross-section-text'>";
                    $output .= "<div class='cross-section-container'>";
                        $output .= $content;
                        if ( $link && $link_txt ):
                            $output .= "<p class=\"link-text\">" . $link_txt . "</p>";
                        endif;
                    $output .= "</div>";
                $output .= "</div>";
                if ( $img_pos == 'right' && $image):
                $output .= "<picture class='cross-section-img img-right'>";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-lg-desktop'] . "\" media=\"(min-width: " . $lg_breakpoint . ")\">";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-desktop'] . "\" media=\"(min-width: " . $md_breakpoint . ")\">";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-sm-desktop'] . "\" media=\"(min-width: " . $sm_breakpoint . ")\">";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-tablet'] . "\" media=\"(min-width: " . $xs_breakpoint . ")\">";
                    $output .= "<source srcset=\"" . $image['sizes']['callout-phone'] . "\">";
                    $output .= "<img src=\"" . $image['sizes']['callout-desktop'] . "\" class=\"img-responsive\" alt=\"" . $image['alt'] . "\" />";
                $output .= "</picture>";
                endif;
            $output .= "</div>";
        if ( $link && $link_url ): 
            $output .= "</a>"; 
        endif;
        
        return $output;
    }