<?php
add_action('after_setup_theme', 'blankslate_setup');
function blankslate_setup()
{
    load_theme_textdomain('blankslate', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'navigation-widgets'));
    add_theme_support('woocommerce');
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1920;
    }
    register_nav_menus(array('main-menu' => esc_html__('Main Menu', 'blankslate')));
}
add_action('admin_notices', 'blankslate_notice');
function blankslate_notice()
{
    $user_id = get_current_user_id();
    $admin_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $param = (count($_GET)) ? '&' : '?';
    if (!get_user_meta($user_id, 'blankslate_notice_dismissed_8') && current_user_can('manage_options'))
        echo '<div class="notice notice-info"><p><a href="' . esc_url($admin_url), esc_html($param) . 'dismiss" class="alignright" style="text-decoration:none"><big>' . esc_html__('Ⓧ', 'blankslate') . '</big></a>' . wp_kses_post(__('<big><strong>📝 Thank you for using BlankSlate!</strong></big>', 'blankslate')) . '<br /><br /><a href="https://wordpress.org/support/theme/blankslate/reviews/#new-post" class="button-primary" target="_blank">' . esc_html__('Review', 'blankslate') . '</a> <a href="https://github.com/tidythemes/blankslate/issues" class="button-primary" target="_blank">' . esc_html__('Feature Requests & Support', 'blankslate') . '</a> <a href="https://calmestghost.com/donate" class="button-primary" target="_blank">' . esc_html__('Donate', 'blankslate') . '</a></p></div>';
}
add_action('admin_init', 'blankslate_notice_dismissed');
function blankslate_notice_dismissed()
{
    $user_id = get_current_user_id();
    if (isset($_GET['dismiss']))
        add_user_meta($user_id, 'blankslate_notice_dismissed_8', 'true', true);
}
add_action('wp_enqueue_scripts', 'blankslate_enqueue');
function blankslate_enqueue()
{
    wp_enqueue_style('blankslate-style', get_stylesheet_uri());
    wp_enqueue_script('jquery');
}
add_action('wp_footer', 'blankslate_footer');
function blankslate_footer()
{
    ?>
        <script>
            jQuery(document).ready(function ($) {
                var deviceAgent = navigator.userAgent.toLowerCase();
                if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
                    $("html").addClass("ios");
                    $("html").addClass("mobile");
                }
                if (deviceAgent.match(/(Android)/)) {
                    $("html").addClass("android");
                    $("html").addClass("mobile");
                }
                if (navigator.userAgent.search("MSIE") >= 0) {
                    $("html").addClass("ie");
                }
                else if (navigator.userAgent.search("Chrome") >= 0) {
                    $("html").addClass("chrome");
                }
                else if (navigator.userAgent.search("Firefox") >= 0) {
                    $("html").addClass("firefox");
                }
                else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
                    $("html").addClass("safari");
                }
                else if (navigator.userAgent.search("Opera") >= 0) {
                    $("html").addClass("opera");
                }
            });
        </script>
        <?php
}
add_filter('document_title_separator', 'blankslate_document_title_separator');
function blankslate_document_title_separator($sep)
{
    $sep = esc_html('|');
    return $sep;
}
add_filter('the_title', 'blankslate_title');
function blankslate_title($title)
{
    if ($title == '') {
        return esc_html('...');
    } else {
        return wp_kses_post($title);
    }
}
function blankslate_schema_type()
{
    $schema = 'https://schema.org/';
    if (is_single()) {
        $type = "Article";
    } elseif (is_author()) {
        $type = 'ProfilePage';
    } elseif (is_search()) {
        $type = 'SearchResultsPage';
    } else {
        $type = 'WebPage';
    }
    echo 'itemscope itemtype="' . esc_url($schema) . esc_attr($type) . '"';
}
add_filter('nav_menu_link_attributes', 'blankslate_schema_url', 10);
function blankslate_schema_url($atts)
{
    $atts['itemprop'] = 'url';
    return $atts;
}
if (!function_exists('blankslate_wp_body_open')) {
    function blankslate_wp_body_open()
    {
        do_action('wp_body_open');
    }
}
add_action('wp_body_open', 'blankslate_skip_link', 5);
function blankslate_skip_link()
{
    echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__('Skip to the content', 'blankslate') . '</a>';
}
add_filter('the_content_more_link', 'blankslate_read_more_link');
function blankslate_read_more_link()
{
    if (!is_admin()) {
        return ' <a href="' . esc_url(get_permalink()) . '" class="more-link">' . sprintf(__('...%s', 'blankslate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}
add_filter('excerpt_more', 'blankslate_excerpt_read_more_link');
function blankslate_excerpt_read_more_link($more)
{
    if (!is_admin()) {
        global $post;
        return ' <a href="' . esc_url(get_permalink($post->ID)) . '" class="more-link">' . sprintf(__('...%s', 'blankslate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}
add_filter('big_image_size_threshold', '__return_false');
add_filter('intermediate_image_sizes_advanced', 'blankslate_image_insert_override');
function blankslate_image_insert_override($sizes)
{
    unset($sizes['medium_large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    return $sizes;
}
add_action('widgets_init', 'blankslate_widgets_init');
function blankslate_widgets_init()
{
    register_sidebar(
        array(
            'name' => esc_html__('Sidebar Widget Area', 'blankslate'),
            'id' => 'primary-widget-area',
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action('wp_head', 'blankslate_pingback_header');
function blankslate_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s" />' . "\n", esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('comment_form_before', 'blankslate_enqueue_comment_reply_script');
function blankslate_enqueue_comment_reply_script()
{
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
function blankslate_custom_pings($comment)
{
    ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <?php echo esc_url(comment_author_link()); ?>
        </li>
        <?php
}
add_filter('get_comments_number', 'blankslate_comment_count', 0);
function blankslate_comment_count($count)
{
    if (!is_admin()) {
        global $id;
        $get_comments = get_comments('status=approve&post_id=' . $id);
        $comments_by_type = separate_comments($get_comments);
        return count($comments_by_type['comment']);
    } else {
        return $count;
    }
}

// Load in the styles. 

function cwpai_enqueue_assets()
{
    wp_enqueue_style('bootstrapy', '//assets.acc.org/Arches/latest/dist/css/acc_boot.min.css'); //4.1.44925
    wp_enqueue_style('arches', '//assets.acc.org/Arches/latest/dist/css/acc_uc.min.css');
    wp_enqueue_style('root', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('fonts', '//fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Open+Sans:wght@300..800&display=swap');
    wp_enqueue_script('icons', '//kit.fontawesome.com/71c9d25c4e.js', array(), '1.0', true);

}
add_action('wp_enqueue_scripts', 'cwpai_enqueue_assets');


function cwpai_register_custom_post_type()
{
    $args = array(
        'public' => true,
        'label' => 'FAQ',
        // Add other arguments as needed
    );
    register_post_type('faq', $args);
    $args = array(
        'public' => true,
        'label' => 'Videos',
        // Add other arguments as needed
    );
    register_post_type('videos', $args);
    $args = array(
        'public' => true,
        'label' => 'Partners',
        // Add other arguments as needed
    );
    register_post_type('partners', $args);
    $args = array(
        'public' => true,
        'label' => 'Press Releases',
        // Add other arguments as needed
    );
    register_post_type('pressreleases', $args);
}
add_action('init', 'cwpai_register_custom_post_type');

// Check if Advanced Custome Feilds is a part of the build.
function check_required_plugin()
{
    if (!is_plugin_active('advanced-custom-fields/acf.php')) {
        add_action('admin_notices', 'required_plugin_notice');
    }
}
add_action('admin_init', 'check_required_plugin');

function required_plugin_notice()
{
    ?>
        <div class="error">
            <p><?php _e('The theme requires the Advanced Custom Fields (ACF) Plugin. Please <a href="' . admin_url('plugins.php') . '">activate it</a> to enable all features.', 'text-domain'); ?></p>
        </div>
        <?php
}
// Allow svg
function allow_svg_upload($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');


// New Main Nav Function

class Custom_Walker_Nav_Menu extends Walker_Nav_Menu
{
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'relative';
        if (in_array('current-menu-item', $item->classes)) {
            $classes[] = 'active';
        }
        $output .= $indent . '<li class="' . implode(' ', $classes) . '">';

        // Check if this item has a submenu and is a top-level item
        
        $atts = array();
        $atts['href'] = !empty($item->url) ? $item->url : '';
        if ($depth === 0 && in_array('menu-item-has-children', $item->classes)) {
            // Parent link classes
            $atts['class'] = $args->class;
        } else {
            // Child link classes
            $atts['class'] = $args->sub_class;
        }

        if ($depth === 0) {
            if (in_array('menu-item-has-children', $item->classes)) {
                // Parent link classes (top-level item with children)
                $atts['class'] =  $args->class;
            } else {
                // Top-level item without children
                $atts['class'] =  $args->class;
            }
        } else {
            // Child link classes
            $atts['class'] = $args->sub_class;
        }


        if ($depth === 0 && in_array('menu-item-has-children', $item->classes)) {
            $output .= '<div class="flex nowrap flex_row-reverse br-l_1 br-r_1 br_solid br_black-5">';
            // Parent link button
            $output .= '<a  href="'.$atts['href'] .'" class="'.$atts['class'] .' p-l_3 p-l_3:md p-l_4:lg">' . apply_filters('the_title', $item->title, $item->ID) . '</a>';
        }

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '" ';
            }
        }

        $link_text = apply_filters('the_title', $item->title, $item->ID);

        $item_output = $args->before;
        if ($depth > 0 || !in_array('menu-item-has-children', $item->classes)) {
            $item_output .= '<a' . $attributes .'">';
            $item_output .= $args->link_before . $link_text . $args->link_after;
            $item_output .= '</a>';
        }
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    // Override start_lvl method
    public function start_lvl(&$output, $depth = 0, $args = array()) {
        if ($depth === 0) {
            // Dropdown toggle button
            $output .= '<button class="'. $args->toggle_class .' br-r_1 br_white-3 br_dotted" data-bs-toggle="dropdown" aria-expanded="false">';
            $output .= '<span class="visually-hidden">Toggle Dropdown</span> <i class="fas fa-solid  faw icon-toggle_plus-minus "></i>';
            $output .= '</button>';
        }
        $output .= '<div class="dropdown-menu br_square w_100 p_4"><ul class="ul_none flex flex_column gap_3">';
    }

    // Override end_lvl method
    public function end_lvl(&$output, $depth = 0, $args = array()) {
        $output .= '</ul></div>';
        if ($depth === 0) {
            $output .= '</div>'; // Close btn-group div
        }
    }
}

// Add Sponosor/Partners Short Code Loop

function codewp_render_custom_posts_partners($atts)
{
    ob_start();

    // Get the custom post type posts
    $args = array(
        'post_type' => 'partners',
        'posts_per_page' => -1,
        // Retrieve all posts
    );

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
add_shortcode('partner_loop', 'codewp_render_custom_posts_partners');



// Add Sponosor/videos Short Code Loop

function codewp_render_custom_posts_videos($atts)
{
    ob_start();

    $atts = shortcode_atts(
        array(
            'count' => -1, // Default count value
            'cols_large' => 3,
            'cols_medium' => 2,

        ),
        $atts,
        'videos_loop'
    );

    $count = intval($atts['count']);

    // Get the custom post type posts
    $args = array(
        'post_type' => 'videos',
        'posts_per_page' => $count,
        'meta_key' => 'release_date', // The key of your custom date field
        'orderby' => 'meta_value_datetime', // or 'meta_value' if the date is stored as a string
        'order' => 'ASC', // Descending order
        // Retrieve all posts
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<div class="flex flex_column grid:md columns_'.$atts['cols_medium'].':md columns_'.$atts['cols_large'].':lg gap_4:md gap_5 gap_5:lg">';
        while ($query->have_posts()) {
            $query->the_post();
            $title = get_the_title();
            $sub_title = get_field('sub_title');
            $video_emebed = get_field('video_emebed');
            $banner_image = get_field('banner_image');
            $thumbnail = get_field('thumbnail');
            $release_date = get_field('release_date');
            $teaser_message = get_field('teaser_message');           
            $description = get_the_content();      
            $url = esc_url( get_permalink());
            $pub_Date = new DateTime($release_date);
            $today_Date = new DateTime();
            $register_url = get_field('register_url');
            // Render your custom fields here
            // You can use the Advanced Custom Fields functions like `get_field()` to retrieve the field values

            $isPast = $pub_Date < $today_Date;

            ?>

<article
    class="wrapper-container bg_white-9 br_1 br_black-2 br_black-3 br_radius br_solid flex flex_column font_copy relative shadow_overlap-light br-br_square br-bl_square">
    <div data-type="img-header"
        class="br-tr_radius br-tl_radius bg-blend_multiply br_1 br_solid br_black-3 bg_cover bg_left m-x_n1 m-t_n1 expand-br_1 aspect_custom-sm bg-blend_multiply br_1 br_solid br_black-3 bg_cover bg_left m-x_n1 m-t_n1 flex_none br-tr_radius br-tl_radius"
        style='background-image: url(<?php echo $banner_image; ?>); aspect-ratio: 350/80;width: calc(100% + 2px);'>
    </div>
    <div class="relative">
        <?php if( $isPast){ ?>
        <aside data-type="date"
            class="float_left m-l_4 m-l_5:lg br-t_0 br_1 br_solid br_black-4 bg_info c_white p-x_4 p-y_4  text_center:md font_display z_3 shadow_overlap-light m-t_n5">
            <span class="block font-size_down-1 font_xbold lh_0 p-x_2:lg uppercase">Watch</span>
            <span class="block font-size_up-1 font_light lh_0 p-x_2:lg m-t_2 uppercase">Now</span>
        </aside>
        <?php }else{ ?>
        <aside data-type="date"
            class="float_left m-l_4 m-l_5:lg br-t_0 br_1 br_solid br_black-4 bg_info c_white p-x_4 p-y_4  text_center:md font_display z_3 shadow_overlap-light m-t_n5">
            <span class="block font-size_down-1 font_xbold lh_0 p-x_2:lg uppercase"><?php echo $pub_Date->format('M'); ?> </span>
            <span class="block font-size_up-1 font_light lh_0 p-x_2:lg m-t_2 uppercase"><?php echo $pub_Date->format('d'); ?></span>
        </aside>
        <?php } ?>
    </div>
    <header class="clear_both p-x_4 p-x_5:lg p-t_2">
        <span data-type="sub-header"
            class="font_display font-size_up c_primary-1 m-t_2 m-t_4:lg m-t_3:md m-b_2 lh_0 font_medium block"><?php
           echo $sub_title ?></span>

        <span data-type="header" class="font_display font-size_up-1 c_primary-n4 m-t_2 m-b_2 lh_1 font_medium"><?php
            echo $title; ?></span>
        <div class="font_ui c_primary-n2 font_xbold font-size_down-2 m-t_n2 uppercase" data-type="type"><?php echo 'video' ?></div>
    </header>
    <ul class="m-b_4:md p-x_4 p-x_5:lg font-size_down-1 ul_none lh_4 no-marker">
        <li class="flex flex_row">
            <i class="fas font-size_up flex_none p-r_3 self_center fa-clock c_black-5"></i>
            <?php if( $isPast){ ?>
            <span class="flex_auto inline-block self_start lh_1 font_accent">On Demand</span>
            <?php }else{ ?>
            <span class="flex_auto inline-block self_start lh_1 font_accent"><?php echo $pub_Date->format('M. j \@ g:i a'); ?></span>
            <?php } ?>
        </li>
    </ul>
    <footer class="flex justify_around justify_start m-t_auto gap-x_3 p-t_4 p-t_3:md p-x_5:lg p-x_4 p-b_4">
         <?php if( $isPast){ ?>
            <a data-type="url" href="<?php echo $url; ?>" target="_blank"
            class="bg_primary h:undecorated br_none br_primary-n3 br_radius c_white ease_out f:outline_none flex_auto flex_shrink not-link font_medium font_ui h:bg_primary-n2 h:c_white inline-block lh_0 m-b_2 max-w_20:md p-x_4 p-y_3 shadow_overlap-light text_center:md transition_1 w_auto"
            rel="noopener">
            <span class="flex">
               
                <span class="flex_grow">Watch</span>
              
            </span>
        </a> <?php }else{ 
            if($register_url){
            ?>
              <a data-type="url" href="<?php echo $register_url; ?>" target="_blank"
            class="bg_primary h:undecorated br_none br_primary-n3 br_radius c_white ease_out f:outline_none flex_auto flex_shrink not-link font_medium font_ui h:bg_primary-n2 h:c_white inline-block lh_0 m-b_2 max-w_20:md p-x_4 p-y_3 shadow_overlap-light text_center:md transition_1 w_auto"
            rel="noopener">
            <span class="flex">
                <span class="flex_grow">Register</span>
            </span>
        </a>
            <?php
            }else{
            ?>
            <div data-type="url-missing"
            class="bg_secondary br_none br_secondary-n3 br_radius disabled opacity_5 c_white ease_out f:outline_none flex_auto flex_shrink not-link font_medium font_ui inline-block lh_0 m-b_2 max-w_20:md p-x_4 p-y_3 shadow_overlap-light text_center:md transition_1 w_auto"
            rel="noopener">
                <span class="flex">
                    <span class="flex_grow">Coming Soon</span>
                </span>
            </div>
            <?php              
            }
            ?> 
            
          
            <?php } ?>
    </footer>
    </article>


            
            <?php
            }
        echo '</div>';
    }
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('videos_loop', 'codewp_render_custom_posts_videos');
