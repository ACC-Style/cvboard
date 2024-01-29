<?php
/*
Template Name: Home Template
*/

get_header();


?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
<!--[if (lt IE 9)]><script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.helper.ie8.js"></script><![endif]-->

    <div class="bg_primary-n2 full-width relative isolation_isolate" >
    <div id="hero-slider">
<?php
$args = array(
    'post_type'      => 'heroslides', // Custom post type name
    'posts_per_page' => -1,           // Get all posts
    'post_status'    => 'publish',    // Only published posts
);

$heroslides_query = new WP_Query($args);

if ($heroslides_query->have_posts()) :
    while ($heroslides_query->have_posts()) : $heroslides_query->the_post();

        // Fetch custom fields
        $image_id = get_field('image'); // Assuming 'image' returns an attachment ID
        $label = get_field('label');    // Text for the h1 element
        $image_src = wp_get_attachment_image_src($image_id, 'full')[0]; // Get the image URL
        $background_color_class = get_field('background_color'); 
?>

        <!-- Your HTML structure -->
		<div>
        <div class="aspect_16x9:md aspect_2x3 aspect_3x1:lg grid justify_center lg p-y_6:lg relative <?php echo $background_color_class;?>">
            <div class="grid:md flex flex_column justify_center items_center inset_0 grid-page-layout">
                <div class="left-breakout-to-center p-x_6 p-x_4:md p-x_0:lg">
                    <img src="<?php echo esc_url($image_src); ?>"
                         class="bg_contain w_100">
                </div>
                <div class="reading-typography c_white color_inherit font_10:lg font_5:md font_3 p-x_4 center-to-right p-x_5:lg self_start self_center:md m-t_5 m-t_0:md">
                    <h1 class="font-size_up-2 text_center text_left:md"><?php echo esc_html($label); ?></h1>
                </div>
            </div>
        </div>

			        </div>

<?php
    endwhile;
    wp_reset_postdata();
endif;
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
    edgePadding: 24,
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
<?php
// Get the ID of the home page
$home_id = get_option('page_on_front');
// Query child pages of the home page

$child_pages_query = new WP_Query(
    array(
        'post_type' => 'page',
        'post_parent' => $home_id,


        )
    );

    
    ?>

<div id="container" class="grid-page-layout grid m-t_n5 z_2 gap-y_4">
 
 <?php
if ($child_pages_query->have_posts()):
    $i = 1;
    while ($child_pages_query->have_posts()):
        $container_style = "";
        $headline_style = "";
        $content_style = "";
        $show_headline = true;
        switch ($i) {
            case 1:
                $container_style="bg_white breakout br_radius br_solid br_black-1 shadow_bevel-bold p-x_6:lg p-x_5:md p-x_4 p-b_6:lg p-b_4:md p-b_6:lg";
                $content_style='font-size_up';
                $show_headline = false;
            break;
            case 3:
                $container_style = "bg_primary-n1 full-width p-b_5:lg p-b_4 reading-typography";
                $headline_style = "c_white";
                $content_style = "c_white color_inherit max-w_65";
                break;    
            default:
                $container_style = "p-b_5:lg p-b_4 reading-typography ";
                if ($i % 2  == 1 && $i != 1) {
                    $container_style = $container_style ." bg_black-3 full-width ";
                    $headline_style = "c_secondary-n3";
                    $content_style = " max-w_65";
                }
                break;
                
        }
        $child_pages_query->the_post();
        ?>
                <section class="relative m-b_6:lg m-b_4:md m-b_5:lg p-y_6:lg p-y_4 <?php echo $container_style;?>">
                 <?php if($show_headline){ ?>
                    <h1 class="font_10:lg font_7:md font_4 font_display <?php echo $headline_style; ?>">
                        <?php the_title() ?>
                    </h1>
                    <?php
                    };
                    ?>
                    <div class="m-t_4:lg m-t_3:md <?php echo $content_style; ?>">
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
