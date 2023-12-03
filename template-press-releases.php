<?php
/*
Template Name: Press Release Template
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
<section class=" grid grid-page-layout ">
<ul class="ul_none p_5:lg p_4:md p_3 wrapper-container flex_column flex gap_3">
        
    <?php
    // Arguments for the query
    $args = array(
    'post_type' => 'pressreleases', // Custom post type 'pressreleases'
    'posts_per_page' => -1, // Get all posts
    );
    
    // The Query
    $pressreleases_query = new WP_Query($args);
    
    // The Loop
    if ($pressreleases_query->have_posts()) {
    while ($pressreleases_query->have_posts()) {
        $pressreleases_query->the_post();
        ?>
        <li class="br_radius flex flex_column flex_row:md gap_3 h:bg_primary-4 p_3 p_4:md relative">
            <a href="<?php echo get_permalink() ?>" class="expanded-click-area flex_0 flex_auto font-size_up-1 font_display link">
            <i class="fa-newspaper fa-solid p-r_3"></i>
            <?php the_title(); ?></a>
            <span class="flex_shrink font-size_down-1 font_medium font_ui m-l_auto:md self_center"><?php echo get_field('release_date'); ?></span></li>
        <?php
    }
    } else {
    // No posts found
    echo '<p>No Press Releasess found.</p>';
    }
    
    // Restore original Post Data
    wp_reset_postdata();
    ?>
</ul>

</section>



<?php get_footer(); ?>