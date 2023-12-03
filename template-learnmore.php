<?php
/*
Template Name: Learn More Template
*/

get_header();


?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'reading-typography grid grid-page-layout z_2 bg_white'); ?>>
<div class="p_4 p_5:lg"><header class="header">
<h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1> <?php edit_post_link(); ?>
</header>
<div class="entry-content " itemprop="mainContentOfPage" class="">
<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) ); } ?>
<?php the_content(); ?>
<div class="entry-links"><?php wp_link_pages(); ?></div>
</div>
</div>
</article>
<?php endwhile; endif; ?>
<section class='reading-typography grid-page-layout grid'>
    <div class="full-width bg_secondary-4">
    <div class="p_4 p-x_5:lg">
<h2>Frequently Asked Questions</h2>

<?php
// Arguments for the query
$args = array(
    'post_type' => 'faq', // Custom post type 'faq'
    'posts_per_page' => -1, // Get all posts
);

// The Query
$faq_query = new WP_Query($args);

// The Loop
if ($faq_query->have_posts()) {
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
    // No posts found
    echo '<p>No FAQs found.</p>';
}

// Restore original Post Data
wp_reset_postdata();
?>
</div>
</div>
</section>


<?php get_footer(); ?>