<?php
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

// Replace bellow this line.
add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
	'key' => 'group_656e188f2d3f6',
	'title' => 'Hero Slide',
	'fields' => array(
		array(
			'key' => 'field_656e1890d8081',
			'label' => 'Label',
			'name' => 'label',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => 'Max Character Limit 60',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => 65,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_65ba94b8ae3d6',
			'label' => 'Sub Label',
			'name' => 'sub_label',
			'aria-label' => '',
			'type' => 'true_false',
			'instructions' => 'This will change the display mode and you must also include the CTA',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'ui' => 1,
		),
		array(
			'key' => 'field_65ba948dae3d5',
			'label' => 'Sub Label Text',
			'name' => 'sub_label_text',
			'aria-label' => '',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_65ba94b8ae3d6',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => 100,
			'rows' => '',
			'placeholder' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_656e18b4d8082',
			'label' => 'Image',
			'name' => 'image',
			'aria-label' => '',
			'type' => 'image',
			'instructions' => 'This should be a Transparent Image that is square',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
			'preview_size' => 'medium',
		),
		array(
			'key' => 'field_656e2041c5cf0',
			'label' => 'Background Color',
			'name' => 'background_color',
			'aria-label' => '',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'bg_primary' => 'Primary',
				'bg_primary-n2' => 'Primary Darker',
				'bg_primary-n4' => 'Primary Darkest',
				'bg_secondary' => 'Secondary',
				'bg_secondary-n2' => 'Secondary Darker',
				'bg_secondary-n4' => 'Secondary Darkest',
				'bg_accent' => 'Accent',
				'bg_accent-n2' => 'Accent Darker',
				'bg_accent-n4' => 'Accent Darkest',
				'bg_highlight-n1' => 'Highlight',
				'bg_highlight-n3' => 'Highlight Darker',
				'bg_highlight-n5' => 'Highlight Darkest',
			),
			'default_value' => 'bg_primary-n2',
			'return_format' => 'value',
			'multiple' => 0,
			'allow_null' => 0,
			'ui' => 0,
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_65ba91689e1ba',
			'label' => 'CTA',
			'name' => 'cta',
			'aria-label' => '',
			'type' => 'true_false',
			'instructions' => 'Include a CTA',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Select to Include a CTA with is slide',
			'default_value' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'ui' => 1,
		),
		array(
			'key' => 'field_65ba90f59e1b9',
			'label' => 'CTA Link',
			'name' => 'cta_link',
			'aria-label' => '',
			'type' => 'link',
			'instructions' => 'When using a CTA this where the button will link to.',
			'required' => 1,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_65ba91689e1ba',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'heroslides',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );

	acf_add_local_field_group( array(
	'key' => 'group_653ab3ac17609',
	'title' => 'Partners',
	'fields' => array(
		array(
			'key' => 'field_653ab3ad1f5e4',
			'label' => 'Logo',
			'name' => 'logo',
			'aria-label' => '',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
			'preview_size' => 'medium',
		),
		array(
			'key' => 'field_653ab3e705b60',
			'label' => 'Partner Name',
			'name' => 'partner_name',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Name',
			'maxlength' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_653ab40d05b61',
			'label' => 'URL',
			'name' => 'url',
			'aria-label' => '',
			'type' => 'url',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'https://acc.org/',
			'placeholder' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'partners',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );

	acf_add_local_field_group( array(
	'key' => 'group_656cfd744e289',
	'title' => 'PIllar',
	'fields' => array(
		array(
			'key' => 'field_656cfd75e2661',
			'label' => 'Image',
			'name' => 'image',
			'aria-label' => '',
			'type' => 'image',
			'instructions' => 'Please only use images that have an aspect ratio of 1 by 1 (Square)',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'library' => 'all',
			'min_width' => 100,
			'min_height' => 100,
			'min_size' => '',
			'max_width' => 1000,
			'max_height' => 1000,
			'max_size' => '',
			'mime_types' => 'jpg, png',
			'preview_size' => 'medium',
		),
		array(
			'key' => 'field_656cfd94e2662',
			'label' => 'Short Title',
			'name' => 'short_title',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => 50,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_656cfdbae2663',
			'label' => 'Teaser Text',
			'name' => 'short_text',
			'aria-label' => '',
			'type' => 'textarea',
			'instructions' => 'This is the text that shows up on the homepage. it should be short compelling and lead the reader to the learn more page.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => 150,
			'rows' => '',
			'placeholder' => '',
			'new_lines' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'pillars',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );

	acf_add_local_field_group( array(
	'key' => 'group_656e36ec3491f',
	'title' => 'Quote',
	'fields' => array(
		array(
			'key' => 'field_656e36ed27f02',
			'label' => 'Name',
			'name' => 'name',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_656e38bcd9f71',
			'label' => 'headshot',
			'name' => 'headshot',
			'aria-label' => '',
			'type' => 'image',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
			'preview_size' => 'medium',
		),
		array(
			'key' => 'field_656e3778a45f9',
			'label' => 'Title',
			'name' => 'title',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_656e370b27f03',
			'label' => 'Company Name',
			'name' => 'company_name',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_656e373627f04',
			'label' => 'Location',
			'name' => 'location',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => 'City, State, Country Abreviation',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'placeholder' => 'New York, NY, USA',
			'prepend' => '',
			'append' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'quotes',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );

	acf_add_local_field_group( array(
	'key' => 'group_656b8e167fc4e',
	'title' => 'Release Date',
	'fields' => array(
		array(
			'key' => 'field_656b8e17a72c4',
			'label' => 'Release Date',
			'name' => 'release_date',
			'aria-label' => '',
			'type' => 'date_time_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'F j, Y g:i a',
			'return_format' => 'Y-m-d H:i:s',
			'first_day' => 1,
		),
		array(
			'key' => 'field_6578676ac5828',
			'label' => 'Teaser Message',
			'name' => 'teaser_message',
			'aria-label' => '',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => 250,
			'rows' => '',
			'placeholder' => '',
			'new_lines' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'milestones',
			),
		),
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'videos',
			),
		),
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'partners',
			),
		),
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'pressreleases',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );

	acf_add_local_field_group( array(
	'key' => 'group_656b4296df3ec',
	'title' => 'Videos',
	'fields' => array(
		array(
			'key' => 'field_656b4298c1f7a',
			'label' => 'Sub Title',
			'name' => 'sub_title',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => 100,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_656b42d3c1f7b',
			'label' => 'Video Emebed',
			'name' => 'video_emebed',
			'aria-label' => '',
			'type' => 'oembed',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '100',
				'class' => 'w_100',
				'id' => '',
			),
			'width' => 576,
			'height' => 324,
		),
		array(
			'key' => 'field_656b4301c1f7c',
			'label' => 'Banner Image',
			'name' => 'banner_image',
			'aria-label' => '',
			'type' => 'image',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'library' => 'all',
			'min_width' => 350,
			'min_height' => 80,
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => 'jpg,png',
			'preview_size' => 'medium',
		),
		array(
			'key' => 'field_656b43727dc33',
			'label' => 'Thumbnail',
			'name' => 'thumbnail',
			'aria-label' => '',
			'type' => 'image',
			'instructions' => '1280 x720',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => 'aspect_16x9',
				'id' => '',
			),
			'return_format' => 'url',
			'library' => 'all',
			'min_width' => 1280,
			'min_height' => 720,
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => 'jpg,png',
			'preview_size' => 'thumbnail',
		),
		array(
			'key' => 'field_656b7a068363e',
			'label' => 'Registration URL',
			'name' => 'registration_url',
			'aria-label' => '',
			'type' => 'url',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'videos',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );
} );

add_action( 'init', function() {
	register_taxonomy( 'faq-category', array(
	0 => 'faq',
), array(
	'labels' => array(
		'name' => 'FAQ Categories',
		'singular_name' => 'FAQ Category',
		'menu_name' => 'FAQ Categories',
		'all_items' => 'All FAQ Categories',
		'edit_item' => 'Edit FAQ Category',
		'view_item' => 'View FAQ Category',
		'update_item' => 'Update FAQ Category',
		'add_new_item' => 'Add New FAQ Category',
		'new_item_name' => 'New FAQ Category Name',
		'search_items' => 'Search FAQ Categories',
		'popular_items' => 'Popular FAQ Categories',
		'separate_items_with_commas' => 'Separate faq categories with commas',
		'add_or_remove_items' => 'Add or remove faq categories',
		'choose_from_most_used' => 'Choose from the most used faq categories',
		'not_found' => 'No faq categories found',
		'no_terms' => 'No faq categories',
		'items_list_navigation' => 'FAQ Categories list navigation',
		'items_list' => 'FAQ Categories list',
		'back_to_items' => '← Go to faq categories',
		'item_link' => 'FAQ Category Link',
		'item_link_description' => 'A link to a faq category',
	),
	'public' => true,
	'show_in_menu' => true,
	'show_in_rest' => true,
) );

	register_taxonomy( 'partner-category', array(
	0 => 'partners',
), array(
	'labels' => array(
		'name' => 'Partner Categories',
		'singular_name' => 'Partner Category',
		'menu_name' => 'Partner Categories',
		'all_items' => 'All Partner Categories',
		'edit_item' => 'Edit Partner Category',
		'view_item' => 'View Partner Category',
		'update_item' => 'Update Partner Category',
		'add_new_item' => 'Add New Partner Category',
		'new_item_name' => 'New Partner Category Name',
		'search_items' => 'Search Partner Categories',
		'popular_items' => 'Popular Partner Categories',
		'separate_items_with_commas' => 'Separate partner categories with commas',
		'add_or_remove_items' => 'Add or remove partner categories',
		'choose_from_most_used' => 'Choose from the most used partner categories',
		'not_found' => 'No partner categories found',
		'no_terms' => 'No partner categories',
		'items_list_navigation' => 'Partner Categories list navigation',
		'items_list' => 'Partner Categories list',
		'back_to_items' => '← Go to partner categories',
		'item_link' => 'Partner Category Link',
		'item_link_description' => 'A link to a partner category',
	),
	'public' => true,
	'show_in_menu' => true,
	'show_in_rest' => true,
) );

	register_taxonomy( 'video-category', array(
	0 => 'videos',
), array(
	'labels' => array(
		'name' => 'Video Categories',
		'singular_name' => 'Video Category',
		'menu_name' => 'Video Categories',
		'all_items' => 'All Video Categories',
		'edit_item' => 'Edit Video Category',
		'view_item' => 'View Video Category',
		'update_item' => 'Update Video Category',
		'add_new_item' => 'Add New Video Category',
		'new_item_name' => 'New Video Category Name',
		'search_items' => 'Search Video Categories',
		'popular_items' => 'Popular Video Categories',
		'separate_items_with_commas' => 'Separate video categories with commas',
		'add_or_remove_items' => 'Add or remove video categories',
		'choose_from_most_used' => 'Choose from the most used video categories',
		'not_found' => 'No video categories found',
		'no_terms' => 'No video categories',
		'items_list_navigation' => 'Video Categories list navigation',
		'items_list' => 'Video Categories list',
		'back_to_items' => '← Go to video categories',
		'item_link' => 'Video Category Link',
		'item_link_description' => 'A link to a video category',
	),
	'public' => true,
	'show_in_menu' => true,
	'show_in_rest' => true,
) );
} );

