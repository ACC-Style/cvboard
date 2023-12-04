<?php get_header(); ?>
<section class="font-size_up grid grid-page-layout p-y_4 p-y_5:md p-y_6:lg" id="reading-page">
    <main class="content">
        ?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'entry' ); ?>
<?php if ( comments_open() && !post_password_required() ) { comments_template( '', true ); } ?>
<?php endwhile; endif; ?>
    </main>
<
</section>
<footer class="footer">
<?php get_template_part( 'nav', 'below-single' ); ?>
</footer>
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