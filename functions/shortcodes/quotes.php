<?php

function fetch_and_display_quotes( $atts ) {
    // Shortcode attributes
    $atts = shortcode_atts( array(
        'id' => '',
        'class' => '',
    ), $atts );

    $args = array(
        'post_type' => 'quotes',
        'posts_per_page' => -1 // Fetch all quotes
    );

    // If an ID is provided, fetch only that quote
    if ( ! empty( $atts['id'] ) ) {
        $args['p'] = $atts['id'];
    }

    $quotes_query = new WP_Query( $args );

    $output = '';

    if ( $quotes_query->have_posts() ) {
        while ( $quotes_query->have_posts() ) {
            $quotes_query->the_post();

            // Use get_field to fetch custom field values
            $name = get_field('name');
            $image_id = get_field('headshot');
            $location = get_field('location');
            $title = get_field('title');
            $company_name = get_field('company_name');

            // Getting the image URL from the image ID
            $image_url = wp_get_attachment_image_url($image_id, 'full'); // 'full' can be changed to other image sizes

            // HTML output
            $output .= '<section class="wrapper-container ' . esc_attr($atts['class']) . '">';
            $output .= '<div class="flex flex_column flex_row:md p-b_4 m-b_4 font_n1 font_0:md font_1:lg gap-x_5:lg gap-x_4:md ">';
            $output .= '<div class="flex_auto m-x_0:md m-x_auto max-w_15 w_100 br_radius shadow_overlap-light overflow_hidden m-b_4 self_start">';
            $output .= '<img class="aspect_1x1 w_100" src="' . esc_url($image_url) . '" alt="' . esc_attr($name) . '">';
            $output .= '</div><div class="flex_auto flex_column justify_start">';
            $output .= '<div class="speaker_bio font-size_up">';
            $output .= '<blockquote class="br_none br_0 br-l_3 br_solid:md br_primary-4 flex flex_row p_4 m-b_0 m-b_4:md"> <i class="c_primary-3 fa-fw fa-quote-left fa-solid fas m-r_3" aria-hidden="true"></i>' . get_the_content() . '<i class="c_primary-3 fa-fw fa-quote-right fa-solid fas m-l_3" aria-hidden="true"></i></blockquote>';
            $output .= '<h2 class="c_primary font-size_down font_display font_medium lh_2 m-y_0 m-x_0:md m-x_4 speaker_name">' . esc_html($name) . '</h2>';
            $output .= '<ul class="speaker_metadata ul_none font_copy font-size_down-1 m-x_0:md m-x_4 ">';
            if ( ! empty( $title ) && ! empty( $company_name ) ) {
                $output .= '<li class="c_black-8 lh_1 m_0 m-b_2 p_0">' . esc_html($title) . ', ' . esc_html($company_name) . '</li>';
            } else {
                $output .= '<li class="c_black-8 lh_1 m_0 m-b_2 p_0">' . esc_html($title . $company_name) . '</li>';
            }
            $output .= '</ul>';
            if( ! empty( $location ) ){
                $output .= '<span class="block c_black-6 font-size_down-2 lh_0 font_italic m-x_0:md m-x_4 ">' . esc_html($location) . '</span>';
            }
            $output .= '</div></div></section>';
        }
    } else {
        $output .= '<p>No quotes found.</p>';
    }

    // Restore original Post Data
    wp_reset_postdata();

    return $output;
}

add_shortcode( 'quotes', 'fetch_and_display_quotes' );