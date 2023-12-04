<?php
// Add Sponosor/Partners Short Code Loop

function codewp_render_custom_posts_partners($atts)
{
    ob_start();

    // Get the custom post type posts
    $args = array(
        'post_type' => 'partners',
        'posts_per_page' => -1,
        // Retrieve all posts
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<ul class="grid columns_3:lg columns_2:md columns_1 gap_5:lg gap_4 p-t_0 p_4 ul_none no-marker">';
        while ($query->have_posts()) {
            $query->the_post();
            $logo = get_field('logo');
            $partner_name = get_field('partner_name');
            $url = get_field('url');
            // Render your custom fields here
            // You can use the Advanced Custom Fields functions like `get_field()` to retrieve the field values

            ?>
            <li class="bg_black-_05 br_1 br_black-_01 br_round br_solid flex flex_column gap-y_3 p-b_4 relative h:bg_black-1">
                <a data-name="sponsor__name" class="expanded-click-area undecorated" target="_blank" href="<?php echo $url; ?>" title="<?php echo $partner_name; ?>" rel="noopener">
                <header class="bg_white br_radius m-b_3 m_4 p_3 shadow_overlap-light w_auto">
                    <div class="relative aspect_16x9 grid justify_center items_center"> 
                    <img decoding="async" alt="Logo of ACC" class="w_90 m-x_auto self_center bg_contain" src="<?php if($logo) {echo $logo;} ?>">
                    
                    </div>
                </header>
                <div class="c_primary-n3 font_3 font_display font_regular lh_1 p-x_4 text_center undecorated">
                    <?php echo $partner_name; ?>
                </div>
                </a>
              </li>
            <?php
            }
        echo '</ul>';
    }
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('partner_loop', 'codewp_render_custom_posts_partners');



// Add Sponosor/videos Short Code Loop

function codewp_render_custom_posts_videos($atts)
{
    ob_start();

    $atts = shortcode_atts(
        array(
            'count' => -1, // Default count value
            'cols_large' => 3,
            'cols_medium' => 2,

        ),
        $atts,
        'videos_loop'
    );

    $count = intval($atts['count']);

    // Get the custom post type posts
    $args = array(
        'post_type' => 'videos',
        'posts_per_page' => $count,
        'meta_key' => 'release_date', // The key of your custom date field
        'orderby' => 'meta_value_datetime', // or 'meta_value' if the date is stored as a string
        'order' => 'ASC', // Descending order
        // Retrieve all posts
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<div class="flex flex_column grid:md columns_'.$atts['cols_medium'].':md columns_'.$atts['cols_large'].':lg gap_4:md gap_5 gap_5:lg">';
        while ($query->have_posts()) {
            $query->the_post();
            $title = get_the_title();
            $sub_title = get_field('sub_title');
            $video_emebed = get_field('video_emebed');
            $banner_image = get_field('banner_image');
            $thumbnail = get_field('thumbnail');
            $release_date = get_field('release_date');
            $teaser_message = get_field('teaser_message');           
            $description = get_the_content();      
            $url = esc_url( get_permalink());
            $pub_Date = new DateTime($release_date);
            $today_Date = new DateTime();
            $register_url = get_field('register_url');
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
        <?php if( $isPast){ ?>
        <aside data-type="date"
            class="float_left m-l_4 m-l_5:lg br-t_0 br_1 br_solid br_black-4 bg_info c_white p-x_4 p-y_4  text_center:md font_display z_3 shadow_overlap-light m-t_n5">
            <span class="block font-size_down-1 font_xbold lh_0 p-x_2:lg uppercase">Watch</span>
            <span class="block font-size_up-1 font_light lh_0 p-x_2:lg m-t_2 uppercase">Now</span>
        </aside>
        <?php }else{ ?>
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
            <?php if( $isPast){ ?>
            <span class="flex_auto inline-block self_start lh_1 font_accent">On Demand</span>
            <?php }else{ ?>
            <span class="flex_auto inline-block self_start lh_1 font_accent"><?php echo $pub_Date->format('M. j \@ g:i a'); ?></span>
            <?php } ?>
        </li>
    </ul>
    <footer class="flex justify_around justify_start m-t_auto gap-x_3 p-t_4 p-t_3:md p-x_5:lg p-x_4 p-b_4">
         <?php if( $isPast){ ?>
            <a data-type="url" href="<?php echo $url; ?>" target="_blank"
            class="bg_primary h:undecorated br_none br_primary-n3 br_radius c_white ease_out f:outline_none flex_auto flex_shrink not-link font_medium font_ui h:bg_primary-n2 h:c_white inline-block lh_0 m-b_2 max-w_20:md p-x_4 p-y_3 shadow_overlap-light text_center:md transition_1 w_auto"
            rel="noopener">
            <span class="flex">
               
                <span class="flex_grow">Watch</span>
              
            </span>
        </a> <?php }else{ 
            if($register_url){
            ?>
              <a data-type="url" href="<?php echo $register_url; ?>" target="_blank"
            class="bg_primary h:undecorated br_none br_primary-n3 br_radius c_white ease_out f:outline_none flex_auto flex_shrink not-link font_medium font_ui h:bg_primary-n2 h:c_white inline-block lh_0 m-b_2 max-w_20:md p-x_4 p-y_3 shadow_overlap-light text_center:md transition_1 w_auto"
            rel="noopener">
            <span class="flex">
                <span class="flex_grow">Register</span>
            </span>
        </a>
            <?php
            }else{
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
        echo '</div>';
    }
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('videos_loop', 'codewp_render_custom_posts_videos');



function codewp_render_custom_posts_pillars($atts)
{
    ob_start();

    $atts = shortcode_atts(
        array(
            'mode' => 'home', // Default count value
        ),
        $atts,
        'pillars_loop'
    );



    // Get the custom post type posts
    $args = array(
        'post_type' => 'pillars',
        'posts_per_page' => -1,
        // Retrieve all posts
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        if ($atts['mode'] === 'home') {
            echo $atts['mode'].'<ul class="gap_5:lg gap_4 columns_1 columns_3:lg grid ul_none">';

        } else {
            echo '<ul class="gap_5:lg gap_4 flex flex_column ul_none">';
        };
        while ($query->have_posts()) {
            $query->the_post();
            $title = get_the_title();
            $short_label = get_field('short_title');
            $htmlID = preg_replace('/[^a-zA-Z0-9-_]/', '', str_replace(' ', '-', $short_label));
            $image_id = get_field('image');
            $long_text = get_the_content();
            $short_text = get_field('short_text');
            $url = home_url('/learnmore/#' . $htmlID);
            $image_src_url = wp_get_attachment_image_url($image_id, 'full');
            $image_srcset_url = wp_get_attachment_image_srcset($image_id, 'full');
                ?>

            <li class="wrapper-container" id="<?php echo $htmlID; ?>">
                    <div id="Specialized" class="flex flex_row:md flex_column gap-x_5">
                        <figure class="flex_none:md flex_20:md grid items_center justify_center"><img fetchpriority="high" decoding="async" 
                        src="<?php echo esc_url($image_src_url).$image_id; ?>" alt="<?php echo $title; ?>" 
                        srcset="<?php echo esc_url($image_srcset_url); ?>" sizes="(max-width: 251px) 100vw, 251px"></figure>
                        <div>
                            <h2 class="text_left:md text_center"> 
                                <?php echo $title; ?>
                            </h2>
                
                            <?php
                            if ($atts['mode'] === 'home') {
                                echo '<p>' . $short_text . '</p>';
                                echo '<a href="' . $url . '" class="link expanded-click-area">Read More <i class="fas fa-solid fa-arrow-right" aria-hidden="true"></i></a>';
                            } else {
                                echo '<p>' . $long_text . '</p>';
                            }
                            ?>
                        </div>
                    </div>
                </li>
            <?php
        }
        if ($atts['mode'] === 'home') {
            echo '</ul>';

        } else {
            echo '</ul>';
        };
    }
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('pillars_loop', 'codewp_render_custom_posts_pillars');