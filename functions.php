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



// Allow svg
function allow_svg_upload($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');

// Remove Comments
function remove_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'remove_comments_admin_menu');
function remove_comments_dashboard_widget() {
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('wp_dashboard_setup', 'remove_comments_dashboard_widget');

// Custom Logo Support
add_theme_support('custom-logo', array(
    'height'      => 160,
    'width'       => 575,
    'flex-height' => true,
    'flex-width'  => true,
    'header-text' => array('site-title', 'site-description'),
));

// Custom Logo Support
function yourtheme_customize_register($wp_customize) {
    // Add setting for alternate logo
    $wp_customize->add_setting('alternate_logo', array(
        'default'           => '',
        'sanitize_callback' => 'absint' // This is because logo IDs are integers.
    ));

    // Add control for alternate logo
    $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'alternate_logo_control', array(
        'label'    => 'Alternate Logo',
        'section'  => 'title_tagline', // This is the section where it will appear
        'settings' => 'alternate_logo',
        'width'    => 575,
        'height'   => 160,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    )));
}

add_action('customize_register', 'yourtheme_customize_register');

// Removing basic posts

function remove_posts_menu() {
    remove_menu_page('edit.php');
}
add_action('admin_menu', 'remove_posts_menu');

include ''. get_template_directory() . '/functions/custom_post_setup.php';
include ''. get_template_directory() . '/functions/main_nav_walker.php';
include ''. get_template_directory() . '/functions/acf_setup.php';
include ''. get_template_directory() . '/functions/shortcodes.php';



// Last Updated
function get_last_updated_date() {
    // Try to get the last updated date from transients
    $last_updated = get_transient('last_updated_date');

    // Check if the transient exists and is not expired
    if ($last_updated === false) {
        // Same query as before
        $args = array(
            'post_type'      => array('post', 'page', 'video', 'partner'),
            'posts_per_page' => -1,
            'fields'         => 'ids',
            'post_status'    => 'publish',
        );

        $query = new WP_Query($args);
        $latest_date = 0;

        if ($query->have_posts()) {
            foreach ($query->posts as $id) {
                $modified_date = get_post_modified_time('U', false, $id);
                if ($modified_date > $latest_date) {
                    $latest_date = $modified_date;
                }
            }
        }

        if ($latest_date != 0) {
            $last_updated = date('F Y', $latest_date);
        } else {
            $last_updated = date('F Y');
        }

        // Set a new transient for a day (86400 seconds)
        set_transient('last_updated_date', $last_updated, 86400);
    }

    return $last_updated;
}

function clear_last_updated_transient_on_post_save($post_id) {
    // If this is just a revision, don't do anything
    if (wp_is_post_revision($post_id)) {
        return;
    }

    // Clear the transient
    delete_transient('last_updated_date');
}

add_action('save_post', 'clear_last_updated_transient_on_post_save');