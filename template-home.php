<?php
/*
Template Name: Home Template
*/

get_header();


?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
<!--[if (lt IE 9)]><script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.helper.ie8.js"></script><![endif]-->
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

    
    ?>
<div class="bg_primary-n2 full-width relative isolation_isolate" >
    <div id="hero-slider">
    <?php 
        the_content(); 

    ?>
    </div>
    <div id="CVHeroSliderControls" class="absolute columns_6 flex inset_0 tns-controls" aria-label="Carousel Navigation" tabindex="0">
        <button class="bg_transparent br_none btn c_white-4 h:c_white items_start  self_center p_5:lg font_4 font_10:lg | m-r_auto" type="button" data-controls="prev" tabindex="-1"><i class="fa-chevron-left fa-thin fa-sharp" aria-hidden="true"></i></button>
        <button class="bg_transparent br_none btn c_white-4 h:c_white items_start  self_center p_5:lg font_4 font_10:lg | m-l_auto" type="button" data-controls="next" tabindex="-1"><i class="fa-chevron-right fa-thin fa-sharp" aria-hidden="true"></i></button>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>
<script>
  var slider = tns({
    container: '#hero-slider',
    items: 1,
    autoHeight: true,
    arrowKeys:true,
    controlsContainer: "#CVHeroSliderControls",
    loop:true,
    slideBy: 'page',
    startIndex: 0,
    edgePadding: 32,
  });
</script>
<style>
    .tns-nav{ 
        position:absolute;
        top:auto;
        bottom:3rem;
        flex-direction:row;
        display:flex;
        gap:.5rem;
        z-index: 1000;
        justify-content: center;
        width:100%;
    }
    .tns-nav > button{
        width:1rem;
        height:1rem;
        overflow:hidden;
        line-height:0;
        background-color: hsla(0,0%,100%,.25)!important;
        border:none;
        transition:.5s;
    }
    .tns-nav > button:hover{

        background-color: hsla(0,0%,100%,1)!important;

    }
    .tns-nav > button.tns-nav-active{
        width:3rem;
        background-color: hsla(0,0%,100%, .75)!important;
    }
</style>

<div id="container" class="grid-page-layout m-t_n5 z_2">
 
 <?php
if ($child_pages_query->have_posts()):
    $i = 1;
    while ($child_pages_query->have_posts()):
        $container_style = "";
        $headline_color = "";
        $copy_color = "";
        $show_headline = true;
        switch ($i) {
            case 1:
                $container_style="bg_white breakout br_radius br_solid br_black-1 shadow_bevel-bold p-x_5:lg p-x_4";
                $show_headline = false;
            break;
            case 3:
                $container_style = "bg_primary-n3 full-width p-b_5:lg p-b_4";
                $headline_color = "c_white";
                $copy_color = "c_white color_inherit";
                break;    
            default:
                $container_style = "p-b_5:lg p-b_4";
                if ($i % 2  == 1 && $i != 1) {
                    $container_style = $container_style ." bg_black-3 full-width";
                    $headline_color = "c_secondary-n3";
                    $copy_color = "";
                }
                break;
                
        }
        $child_pages_query->the_post();
        ?>
                <section class="relative m-b_6 p-t_6 <?php echo $container_style;?>">
                 <?php if($show_headline){ ?>
                    <h1 class="font_10:lg font_7:md font_4 font_display <?php echo $headline_color; ?>">
                        <?php the_title() ?>
                    </h1>
                    <?php
                    };
                    ?>
                    <div class="reading-typography <?php echo $copy_color; ?>">
                    <?php
                    the_content();
                    ?>
                    </div>

                </section>
                <?php
                $i++;
    endwhile;
endif;
?>
</div>
<?php
get_footer();
