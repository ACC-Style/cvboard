<?php
function codewp_render_custom_posts_videos($atts) {
    ob_start();

    // Shortcode default attributes
    $atts = shortcode_atts(
        array(
            'count' => -1, // Default count value
            'cols_large' => 3,
            'cols_medium' => 2,
            'category' => '', // Default term is empty
        ),
        $atts,
        'videos'
    );

    if(!empty($atts['category'])) {
        // If a specific category is passed, display videos from that category
        display_videos_by_category($atts['category'], $atts['count'], $atts['cols_large'], $atts['cols_medium']);
    } else {
        // Display uncategorized videos first
        display_videos_by_category('', $atts['count'], $atts['cols_large'], $atts['cols_medium'], false); // false for not showing the category name

        // Display videos from each category
        $video_categories = get_terms(array(
            'taxonomy' => 'video-category',
            'hide_empty' => true,
        ));

        foreach($video_categories as $category) {
            if(strtolower($category->name) !== 'uncategorized') {
                

                display_videos_by_category($category->slug, $atts['count'], $atts['cols_large'], $atts['cols_medium']);
            }
        }
    }

    return ob_get_clean();
}

function display_videos_by_category($category_slug, $count, $cols_large, $cols_medium, $show_category_name = true) 
    {
    // Query parameters
    $args = array(
        'post_type' => 'videos',
        'posts_per_page' => $count,
        'tax_query' => array(),
    );

    if (!empty($category_slug)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'video-category',
                'field' => 'slug',
                'terms' => $category_slug,
            ),
        );
    } else {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'video-category',
                'operator' => 'NOT EXISTS', // Fetches posts without any 'video-category' terms
            ),
        );
    }

    $query = new WP_Query($args);

    if($query->have_posts()) {
        // Start of the container
        if ($show_category_name && !empty($category_slug)) {
            echo '<h3>' . esc_html(get_term_by('slug', $category_slug, 'video-category')->name) . '</h3>';
        }
       
        echo '<div class="flex flex_column grid:md columns_'.$cols_medium.':md columns_'.$cols_large.':lg gap_4:md gap_5 gap_5:lg">';
        while($query->have_posts()) {
            $query->the_post();
            $title = get_the_title();
            $sub_title = get_field('sub_title');
            $video_emebed = get_field('video_emebed');
            $banner_image = get_field('banner_image');
            $thumbnail = get_field('thumbnail');
            $release_date = get_field('release_date');
            $teaser_message = get_field('teaser_message');
            $description = get_the_content();
            $url = esc_url(get_permalink());
            $pub_Date = new DateTime($release_date);
            $today_Date = new DateTime();
            $register_url = get_field('registration_url');
            // Render your custom fields here
            // You can use the Advanced Custom Fields functions like `get_field()` to retrieve the field values

            $isPast = $pub_Date < $today_Date;

            ?>

            <article
                class="wrapper-container bg_white-9 br_1 br_black-2 br_black-3 br_radius br_solid flex flex_column font_copy relative shadow_overlap-light br-br_square br-bl_square">
                <div data-type="img-header"
                    class="br-tr_radius br-tl_radius bg-blend_multiply br_1 br_solid br_black-3 bg_cover bg_left m-x_n1 m-t_n1 expand-br_1 aspect_custom-sm bg-blend_multiply br_1 br_solid br_black-3 bg_cover bg_left m-x_n1 m-t_n1 flex_none br-tr_radius br-tl_radius"
                    style='background-image: url(<?php echo $banner_image; ?>); aspect-ratio: 350/80;width: calc(100% + 2px);'>
                </div>
                <div class="relative">
                    <?php if($isPast) { ?>
                        <aside data-type="date"
                            class="float_left m-l_4 m-l_5:lg br-t_0 br_1 br_solid br_black-4 bg_info c_white p-x_4 p-y_4  text_center:md font_display z_3 shadow_overlap-light m-t_n5">
                            <span class="block font-size_down-1 font_xbold lh_0 p-x_2:lg uppercase">Watch</span>
                            <span class="block font-size_up-1 font_light lh_0 p-x_2:lg m-t_2 uppercase">Now</span>
                        </aside>
                    <?php } else { ?>
                        <aside data-type="date"
                            class="float_left m-l_4 m-l_5:lg br-t_0 br_1 br_solid br_black-4 bg_info c_white p-x_4 p-y_4  text_center:md font_display z_3 shadow_overlap-light m-t_n5">
                            <span class="block font-size_down-1 font_xbold lh_0 p-x_2:lg uppercase"><?php echo $pub_Date->format('M'); ?> </span>
                            <span class="block font-size_up-1 font_light lh_0 p-x_2:lg m-t_2 uppercase"><?php echo $pub_Date->format('d'); ?></span>
                        </aside>
                    <?php } ?>
                </div>
                <header class="clear_both p-x_4 p-x_5:lg p-t_2">
                    <span data-type="sub-header"
                        class="font_display font-size_up c_primary-1 m-t_2 m-t_4:lg m-t_3:md m-b_2 lh_0 font_medium block"><?php
                        echo $sub_title ?></span>

                    <span data-type="header" class="font_display font-size_up-1 c_primary-n4 m-t_2 m-b_2 lh_1 font_medium"><?php
                    echo $title; ?></span>
                    <div class="font_ui c_primary-n2 font_xbold font-size_down-2 m-t_n2 uppercase" data-type="type"><?php echo 'video' ?></div>
                </header>
                <ul class="m-b_4:md p-x_4 p-x_5:lg font-size_down-1 ul_none lh_4 no-marker">
                    <li class="flex flex_row">
                        <i class="fas font-size_up flex_none p-r_3 self_center fa-clock c_black-5"></i>
                        <?php if($isPast) { ?>
                            <span class="flex_auto inline-block self_start lh_1 font_accent">On Demand</span>
                        <?php } else { ?>
                            <span class="flex_auto inline-block self_start lh_1 font_accent"><?php echo $pub_Date->format('M. j \@ g:i a'); ?></span>
                        <?php } ?>
                    </li>
                </ul>
                <footer class="flex justify_around justify_start m-t_auto gap-x_3 p-t_4 p-t_3:md p-x_5:lg p-x_4 p-b_4">
                    <?php

                    if($isPast) { ?>
                            <a data-type="url" href="<?php echo $url; ?>" target="_blank"
                            class="bg_primary h:undecorated br_none br_primary-n3 br_radius c_white ease_out f:outline_none flex_auto flex_shrink not-link font_medium font_ui h:bg_primary-n2 h:c_white inline-block lh_0 m-b_2 max-w_20:md p-x_4 p-y_3 shadow_overlap-light text_center:md transition_1 w_auto"
                            rel="noopener">
                            <span class="flex">
               
                                <span class="flex_grow">Watch</span>
              
                            </span>
                        </a> <?php } else {

                        if($register_url != '') {
                            ?>
                                  <a data-type="url" href="<?php echo $register_url; ?>" target="_blank"
                                class="bg_primary h:undecorated br_none br_primary-n3 br_radius c_white ease_out f:outline_none flex_auto flex_shrink not-link font_medium font_ui h:bg_primary-n2 h:c_white inline-block lh_0 m-b_2 max-w_20:md p-x_4 p-y_3 shadow_overlap-light text_center:md transition_1 w_auto"
                                rel="noopener">
                                <span class="flex">
                                    <span class="flex_grow">Register</span>
                                </span>
                            </a>
                                <?php
                        } else {
                            ?>
                                <div data-type="url-missing"
                                class="bg_secondary br_none br_secondary-n3 br_radius disabled opacity_5 c_white ease_out f:outline_none flex_auto flex_shrink not-link font_medium font_ui inline-block lh_0 m-b_2 max-w_20:md p-x_4 p-y_3 shadow_overlap-light text_center:md transition_1 w_auto"
                                rel="noopener">
                                    <span class="flex">
                                        <span class="flex_grow">Coming Soon</span>
                                    </span>
                                </div>
                            <?php
                        }
                        ?> 
            
          
                        <?php } ?>
                </footer>
                </article>
             <?php
        }

        echo '</div>'; // End of the container
    }

    wp_reset_postdata();
}

add_shortcode('videos', 'codewp_render_custom_posts_videos');
