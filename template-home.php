<?php
/*
Template Name: Home Template
*/

get_header();


?>
<!-- START: Hero Image -->
<div data-item="hero-image-cta"
    class="hero relative isolation_isolate grid rows_3 rows_2:md columns_4:md columns_5:lg columns_2  overflow_hidden "
    style="--row-1:2.5rem; --row-2:min-content; --hero-overlay-color: #270a64;--hero-overlay-opacity: .6;">
    <picture data-item="responsive-hero-image" class="col_all row_all w_100 flex overflow_hidden">
        <source srcset="<?php echo get_template_directory_uri(); ?>/img/hero/1400x150.jpg" media="(min-width: 1200px)"
            class="display_none">
        <source srcset="<?php echo get_template_directory_uri(); ?>/img/hero/1200x300.jpg" media="(min-width: 1024px)"
            class="display_none">
        <source srcset="<?php echo get_template_directory_uri(); ?>/img/hero/1024x256.jpg" media="(min-width: 768px)"
            class="display_none">
        <source srcset="<?php echo get_template_directory_uri(); ?>/img/hero/600x300.jpg" media="(min-width: 400px)"
            class="display_none">
        <img decoding="async" src="<?php echo get_template_directory_uri(); ?>/img/hero/300x450.jpg" alt="Hero Image"
            class="bg_cover flex_100">
    </picture>

    <div class="col-end_end col-start_start grid items_center justify_center row-end_end row-start_start">

        <div class="columns_2 columns_4:md columns_5:lg grid hero isolation_isolate max-w_70 overflow_hidden relative rows_2:md rows_3 w_100"
            style="--row-1:2.5rem; --row-2:min-content; --hero-overlay-color: #270a64;--hero-overlay-opacity: .6;">
            <div
                class="relative row-start_start row-end_3 col-start_start col-end_3:md col-end_end p-y_5 m-l_4 m-l_0:md">
                <!--h1 style="--hero-overlay-color:var(--secondary);" data-item="hero-title" class="display_none:md c_white m-t_5:lg m-t_4 font_5:lg font_4:md font_3 isolation_isolate relative m-b_n4">
                    <span class="font_xbold font-size_up-2">CVBoard.org</span>
                </h1-->
                <h1 data-item="hero-title"
                    class="c_white m-t_5:lg m-t_4 font_7:lg font_7:md font_5 isolation_isolate relative m-t_0">
                    <span>Building</span>
                    <span>a</span>
                    <span>New</span>
                    <span>Board</span>
                    <span>for</span>
                    <span>Cardiovascular</span>
                    <span>Medicine</span>
                </h1>
                <h4 data-item="cta-title" class="c_white font_display font_medium m-t_0 p-x_4"> </h4>

            </div>
        </div>
    </div>

</div>
<!-- END: Hero Image -->

<?php
// Get the ID of the home page
$home_id = get_option('page_on_front');
// Query child pages of the home page

$child_pages_query = new WP_Query(
    array(
        'post_type' => 'page',
        'post_parent' => $home_id,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'posts_per_page' => -1
    )
);

if ($child_pages_query->have_posts()):
    while ($child_pages_query->have_posts()):
        $child_pages_query->the_post();
        ?>
        <div class="p-y_5:lg p-y_4 relative">
        <div class="font-size_up font_copy font_regular m_auto max-w_65 ">
            <h1 class="font_10 font_display c_primary">
                <?php the_title() ?>
            </h1>
            <div class="p-y_4 reading-typography">
            <?php
            the_content();
            ?>
            </div>
            </div>
        </div>
        <?php
    endwhile;
endif;

get_footer();
