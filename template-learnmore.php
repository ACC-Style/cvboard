<?php
/*
Template Name: Learn More Template
*/

get_header();
$pageID = '';

?>
<?php if ( have_posts() ) : 
    while ( have_posts() ) :
    the_post();
    $page_id = get_the_ID();
    ?>
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
<div class="grid grid-page-layout">
<?php


$child_pages_query = new WP_Query(
    array(
        'post_type' => 'page',
        'post_parent' => $page_id,
    )
);

$output = ""; // Initialize the output variable

if ($child_pages_query->have_posts()):
    $i = 1;
    while ($child_pages_query->have_posts()):
        $child_pages_query->the_post();


        $headline_style = "";
        $content_style = "";
        $show_headline = true;
        $container_style = "p-b_5:lg p-b_4";
        
        if ($i % 2 == 1 ) {
            $container_style .= " bg_secondary-4 full-width";
            $headline_style = "c_secondary-n3";
            $content_style = "max-w_65";
        }

        $output .= "<section class='relative m-b_6:lg m-b_4:md m-b_5:lg p-y_6:lg p-y_4 {$container_style}'>";
        if($show_headline) {
            $output .= "<h1 class='font_10:lg font_7:md font_4 font_display {$headline_style}'>" . get_the_title() . "</h1>";
        }
        $output .= "<div class='reading-typography {$content_style}'>" . do_shortcode(get_the_content()) . "</div>";

        $output .= "</section>";

        $i++;
    endwhile;
endif;

echo $output;
?>


</div>

<?php get_footer(); ?>