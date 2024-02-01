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
<!-- Google Tag Manager --> 
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': 
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], 
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src= 
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f); 
})(window,document,'script','dataLayer','GTM-NQZ7ND3P');</script> 
<!-- End Google Tag Manager --> 
<?php wp_head(); ?>
</head>
<body <?php body_class('bg_info-5 min-h_100 flex flex_column'); ?> >
<!-- Google Tag Manager (noscript) --> 
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NQZ7ND3P" 
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> 
<!-- End Google Tag Manager (noscript) --> 
<?php wp_body_open(); ?>

<header id="header" role="banner" class="grid-page-layout grid:md t_0 l_0 r_0 z_5 bg_white">
<nav  id="menu" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement" class="breakout flex flex_row:md flex_column justify_center">

<h1 class="m-x_auto m-l_0:md m-b_0 self_center">
<?php
if ( !is_front_page()) 
{ echo '<a class="h:undecorated br_none" href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home" itemprop="url">'; }
?>
<?php if (function_exists('the_custom_logo')) {
    the_custom_logo();
} ?> 
<?php
if ( !is_front_page() ) { echo '</a>'; }
?>

</h1>
<?php
wp_nav_menu( array(
    'theme_location' => 'main-menu',
    'container' => 'ul',
    'menu_class' => 'center-to-right c_primary flex flex_row font_0 font_1:md font_2:lg font_display font_medium gap_1 items_center justify_between:md justify_center m-l_auto:md m_0 no-marker ul_none w_100 w_auto:md',
    'link_before' => '<span itemprop="name">',
    'link_after' => '</span>',
    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	'class' => 'a:br_accent h:bg_accent br_transparent br-b_3 br_solid inline-block p_3 p-x_5:lg p-x_4:md relative c_primary expanded-click-area undecorated not-link h:undecorated h:c_white',
    'sub_class' => 'c_black',
	'toggle_class' => 'h:bg_accent br_transparent inline-block p_3 relative  bg_transparent br_square c_primary expanded-click-area undecorated not-link h:undecorated h:c_white',
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

