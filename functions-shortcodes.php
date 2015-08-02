<?php
     // Create Cross Section short code
    add_shortcode( 'cross_section', 'cross_section_shortcode' );
    function cross_section_shortcode( $atts, $content = "" ){
        include "includes/layout.php";
        
        extract (shortcode_atts ( array (
            'img_id' => '',
            'img_pos' => 'left',
            'link' => false,
            'link_txt' => '',
            'link_url' => '',
            'color' => 'green'
        ), $atts ) );
        
        $id = "cross_section_" . rand(0,1000000);

        $image = $img_id;

        $output = "";

        if ( $link && $link_url ):
            $output .= "<a href=\"" . $link_url . "\" target=\"_blank\" id=\"" . $id . "\">";
        endif;
            $output .= "<div class='cross-section " . $color . "-bg'>";
                if ( $img_pos == 'left' && $image):
					$output .= "<div class='cross-section-img'>";
					$output .= get_retina_images($image, array(570,470,370,768));
					$output .= "</div>";
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
					$output .= "<div class='cross-section-img'>";
					$output .= get_retina_images($image, array(570,470,370,768));
					$output .= "</div>";
                endif;
            $output .= "</div>";
        if ( $link && $link_url ): 
            $output .= "</a>"; 
        endif;
        
        return $output;
    }