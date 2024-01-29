<?php

function codewp_render_custom_posts_pillars($atts)
{
    ob_start();

    $atts = shortcode_atts(
        array(
            'layout' => 'home', // Default count value
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
        if ($atts['layout'] === 'home') {
            echo '<ul class="gap_5:lg gap_4 columns_1 columns_3:lg grid ul_none reading-typography">';

        } else {
            echo '<ul class="gap_5:lg gap_4 flex flex_column ul_none reading-typography">';
        };
        while ($query->have_posts()) {
            $query->the_post();
            $title = get_the_title();
            $short_label = get_field('short_title');
            $html_id = preg_replace('/[^a-zA-Z0-9-_]/', '', str_replace(' ', '-', $short_label));
            $image_id = get_field('image');
            $long_text = get_the_content();
            $short_text = get_field('short_text');
            $url = home_url('/learnmore/#' . $html_id);
            $image_src_url = wp_get_attachment_image_url($image_id, 'full');
            $image_srcset_url = '';// wp_get_attachment_image_srcset($image_id, 'full');
                ?>

            <li class="wrapper-container" id="<?php echo $html_id; ?>">
                    <div class="flex flex_row:md flex_column gap-x_5">
                        <figure class="flex_none:md flex_20:md grid items_center justify_center max-w_20 m_auto"><img fetchpriority="high" decoding="async" 
                        src="<?php echo esc_url($image_src_url); ?>" alt="<?php echo $title; ?>" 
                        srcset="<?php echo $image_srcset_url; ?>" sizes="(max-width: 251px) 100vw, 251px"></figure>
                        <div>
                            <h2 class="text_left:md text_center"> 
                                <?php echo $title; ?>
                            </h2>
                
                            <?php
                            if ($atts['layout'] === 'home') {
                                echo '<p>' . $short_text . '</p>';
                                echo '<!-- <a href="' . $url . '" class="link expanded-click-area">Read More <i class="fas fa-solid fa-arrow-right" aria-hidden="true"></i></a> -->';
                            } else {
                                echo '<p>' . $long_text . '</p>';
                            }
                            ?>
                        </div>
                    </div>
                </li>
            <?php
        }
        if ($atts['layout'] === 'home') {
            echo '</ul>';

        } else {
            echo '</ul>';
        };
    }
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('pillars', 'codewp_render_custom_posts_pillars');