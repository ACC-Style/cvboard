<?php

function codewp_render_custom_posts_partners($atts)
{
    ob_start();

    $atts = shortcode_atts(array(
        'category' => '', // Default term is empty
    ), $atts,'partners');
    $filter_cateogry = $atts['category'];

    // Get the custom post type posts
    $args = array(
        'post_type' => 'partners',
        'posts_per_page' => -1,
        'meta_key' => 'partner_name', // Define the custom field to sort by
        'orderby' => 'meta_value', // Sort by the value of the custom field
        'order' => 'ASC', // Sort in ascending order
    );
    if (!empty($filter_cateogry)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'partner_categories', // Replace with your actual taxonomy name
                'field' => 'slug',
                'terms' => $filter_cateogry,
            ),
        );
    }

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
add_shortcode('partners', 'codewp_render_custom_posts_partners');