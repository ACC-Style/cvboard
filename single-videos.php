<?php get_header(); ?>
<section class="font-size_up grid grid-page-layout  p-y_4 p-y_5:md p-y_6:lg" id="reading-page">

<?php if (have_posts()):
    while (have_posts()):
        the_post();

        $release_date = new DateTime( get_field('release_date') );
        ?>
            <h2 class="m_0 c_primary"><?php echo get_field('sub_title') ?></h2>
            <h1><?php the_title(); ?></h1>
        <main class="content grid gap_4 gap_5:lg">
        <div class="content-left">
            <div class="aspect_16x9 video holder embed-container">
            <?php

// Load value.
$iframe = get_field('video_emebed');

// Use preg_match to find iframe src.
preg_match('/src="(.+?)"/', $iframe, $matches);
$src = $matches[1];

// Add extra parameters to src and replace HTML.
$params = array(
    'controls'  => 0,
    'hd'        => 1,
    'autohide'  => 1
);
$new_src = add_query_arg($params, $src);
$iframe = str_replace($src, $new_src, $iframe);

// Add extra attributes to iframe HTML.
$attributes = 'frameborder="0"';
$iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);

// Display customized HTML.
echo $iframe;
?>
<style>
    .embed-container { 
        position: relative; 
        padding-bottom: 56.25%;
        overflow: hidden;
        max-width: 100%;
        height: auto;
    } 

    .embed-container iframe,
    .embed-container object,
    .embed-container embed { 
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>    
            </div>

        </div>
        <div class="reading-typography sidebar-right">
            <?php the_content(); ?>
            <small class="opacity_8 c_primary"><strong>Released:</strong> <?php echo $release_date-> format('M. j, Y '); ?></small>
            </div>
        </main>

    <?php endwhile; endif; ?>
<footer class="br-t_1 br_solid br_primary-3 m-t_4 p-t_3 font_n1">
<?php get_template_part('nav', 'below-single', 'font_n1'); ?>
</footer>
</section>

<style>
    #reading-page.grid-page-layout{
    --content-max-width: 60rem;
    --custom-font-size-modifier: 1.125;
    }
    #reading-page p{
        line-height:1.5;
    }

</style>
<?php get_footer(); ?>