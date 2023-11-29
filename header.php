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
<div id="wrapper" class="hfeed">
<header id="header" role="banner">
<div id="branding">
<div id="site-title" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">

</div>
</div>
<nav  id="menu" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement" class="bg_white br-b_1 br-b_2 br_secondary-n2 br_soild br_solid shadow_overlap-light sticky t_0 z_4">

	<div class="max-w_80 flex flex_row items_center justify_center m_auto flex_wrap">
           <h1> <?php
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
    'menu_class' => 'flex flex_row font_0 font_1:md font_2:lg font_display font_medium gap_1 items_center justify_between justify_center m-l_auto:md m-x_0:md m-x_4 m_0 no-marker ul_none w_100 w_auto:md',
    'link_before' => '<span itemprop="name">',
    'link_after' => '</span>',
    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    'walker' => new Custom_Walker_Nav_Menu()
) );
?>
	</div>
</nav>
</header>
<div id="container">
<main id="content" role="main">