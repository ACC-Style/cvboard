<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php blankslate_schema_type(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Red+Hat+Display:wght@200..900&amp;display=swap">
<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Wix+Madefor+Display:wght@400..800&amp;display=swap">
<script src="https://kit.fontawesome.com/71c9d25c4e.js" crossorigin="anonymous"></script>
<?php wp_head(); ?>
</head>
<body <?php body_class('bg_info-5'); ?>>
<?php wp_body_open(); ?>

<header id="header" role="banner" class="grid-page-layout fixed t_0 l_0 r_0 z_5">
<nav  id="menu" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement" class="full-width">

<h1 class="left-breakout-to-center grid justify_start items_center m_0 font_xbold c_white"> <?php
if ( !is_front_page()) 
{ echo '<a class="h:undecorated" href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home" itemprop="url">'; }
echo '<span itemprop="name">' . esc_html( get_bloginfo( 'name' ) ) . '</span>';
if ( !is_front_page() ) { echo '</a>'; }
?>
</h1>
<?php
wp_nav_menu( array(
    'theme_location' => 'main-menu',
    'container' => 'ul',
    'menu_class' => 'right-breakout-to-center c_white flex flex_row font_0 font_1:md font_2:lg font_display font_medium gap_1 items_center justify_between justify_center m-l_auto:md m-x_0:md m-x_4 m_0 no-marker ul_none w_100 w_auto:md',
    'link_before' => '<span itemprop="name">',
    'link_after' => '</span>',
    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    'walker' => new Custom_Walker_Nav_Menu()
) );
?>
	
</nav>
</header>

<script>
    // The debounce function receives our function as a parameter
const debounce = (fn) => {
	// This holds the requestAnimationFrame reference, so we can cancel it if we wish
	let frame;
	// The debounce function returns a new function that can receive a variable number of arguments
	return (...params) => {
		// If the frame variable has been defined, clear it now, and queue for next frame
		if (frame) {
			cancelAnimationFrame(frame);
		}
		// Queue our function call for the next frame
		frame = requestAnimationFrame(() => {
			// Call our function and pass any params we received
			fn(...params);
		});
	};
};
// Reads out the scroll position and stores it in the data attribute
// so we can use it in our stylesheets
const storeScroll = () => {
	document.documentElement.dataset.scroll = window.scrollY;
};
// Listen for new scroll events, here we debounce our `storeScroll` function
document.addEventListener("scroll", debounce(storeScroll), { passive: true });
// Update scroll position for first time
storeScroll();
</script>

