<?php
function custom_faqs_shortcode($atts) {
    // Extract the attributes from the shortcode
    $atts = shortcode_atts(array(
        'category' => '', // default is empty string
    ), $atts);

    ob_start();

    if (!empty($atts['category'])) {
        display_faqs_by_category($atts['category']);
    } else {
        display_faqs_by_category('');

        // Then, display FAQs from each category
        $faq_categories = get_terms(array(
            'taxonomy' => 'faq-category',
            'hide_empty' => true,
        ));

        foreach ($faq_categories as $category) {
            if (strtolower($category->name) !== 'uncategorized') {
                display_faqs_by_category($category->slug, true);
            }
        }
    }

    return ob_get_clean();
}

// Function to display FAQs by category
function display_faqs_by_category($category_slug, $exclude_tagged = false ) {
    // Modify the query based on category
    $args = array(
        'post_type' => 'faq',
        'posts_per_page' => -1,
        'tax_query' => array(),
    );

    if (!empty($category_slug)) {
        // Fetch FAQs from the specified category
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'faq-category',
                'field' => 'slug',
                'terms' => $category_slug,
            ),
        );
    } else {
        // Fetch untagged FAQs
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'faq-category',
                'operator' => 'NOT EXISTS', // Fetches posts without any 'faq-category' terms
            ),
        );

        if ($exclude_tagged) {
            $args['tax_query'][] = array(
                'taxonomy' => 'faq-category',
                'operator' => 'EXISTS', // Ensures the post has at least one 'faq-category' term
            );
        }
    }
    $faq_query = new WP_Query($args);
    // Debugging: Output the number of posts
    echo '<!-- Number of posts for ' . $category_slug . ': ' . $faq_query->post_count . ' -->';

    if ($faq_query->have_posts()) {
        if (!empty($category_slug)) {
            echo '<h3>' . esc_html(get_term_by('slug', $category_slug, 'faq-category')->name) . '</h3>';
        }
        while ($faq_query->have_posts()) {
            $faq_query->the_post();
            ?>

                <header id="accordion_header_<?php the_ID(); ?>"
                    class="flex flex_row sticky t_n2 bg_white shadow_overlap-light br_solid br_1 br_black-2 z_2 relative collapsed"
                    aria-expanded="false" data-bs-toggle="collapse" data-bs-target="#accordion_content_<?php the_ID(); ?>"
                    aria-controls="accordion_content_<?php the_ID(); ?>">
                    <div class="h:bg_primary-5 m_2 c_primary-n2 h:c_primary-n4 br_radius expanded-click-area">
                        <div class="flex_none">
                            <span class="fa-stack">
                                <i class="fas fa-minus fa-stack-1x"></i>
                                <i class="fas fa-minus rotate_90 a:rotation fa-stack-1x "></i>
                            </span>
                        </div>
                    </div>
                    <div class="font-size_up flex_auto flex flex_row justify_center p-y_2">
                        <div class="flex_auto self_center reading-typography no-margins">
                            <h3 class="lh_2 max-w_50 c_primary-n2">
                                <?php the_title(); ?>
                            </h3>
                        </div>
                    </div>
                </header>
                <main id="accordion_content_<?php the_ID(); ?>" class="bg_white-9 br-bl_radius br-br_radius m-b_3 m-x_0 m-x_3:md p_3 p_4:md reading-typography shadow_emboss-light tab-content transition_4 collapse" aria-labelledby="accordion_header_<?php the_ID(); ?>">
                    <div class="reading-typography">
                        <?php the_content(); ?>
                    </div>
                </main>

                <?php
        }
    } else {
        echo '<p>No FAQs found' . (empty($category_slug) ? '.' : ' in this category.') . '</p>';
    }

    wp_reset_postdata();
}

add_shortcode('faqs', 'custom_faqs_shortcode');