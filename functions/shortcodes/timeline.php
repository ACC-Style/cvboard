<?php

function custom_timeline_shortcode($atts) {
    $attributes = shortcode_atts([
        'sortorder' => 'DESC', // Default sort order
    ], $atts);
    $output = '';
    $current_time = current_time('Y-m-d H:i:s');
    $sort_order = strtoupper($attributes['sortorder']) === 'DESC' ? 'DESC' : 'ASC'; // Ensuring valid sort order

    // Array of phrases for future posts
    $future_phrases = [
        "Arriving Shortly",
        "To Be Released in Future",
        "In the Pipeline",
        "Past the Horizon",
        "On the Roadmap",
        "Forthcoming",
        "Around the Corner",
        "Upcoming",
        "In Progress",
        "Launching Sometime"
    ];
    $past_phrases = [
        "Lost to Time",
        "Ancient History",
        "In the Annals of History",
        "From Time Immemorial",
        "Eons Ago",
        "In the Mists of Antiquity",
        "In the Depths of History",
        "A Distant Memory",
        "From the Dawn of Time",
        "A Relic of the Past"
    ];

    // Query for custom post types
    $args = [
        'post_type' => ['milestones', 'pressreleases', 'videos'],
        'posts_per_page' => -1, // Get all posts
        'meta_key' => 'release_date',
        'orderby' => 'meta_value',
        'order' => $sort_order
    ];

    $query = new WP_Query($args);
    $output .= "<div id='timeline' class='grid isolation_isolate columns_3:md columns_2 rows_2 br-b_3 br_solid br_info-2' style='--col-2: 2rem; --row-1:45px;'>";
    if($query->have_posts()) {
        $i = 0;
        while($query->have_posts()) {
            $query->the_post();

            $release_date = get_field('release_date');
            $date_time = strtotime($release_date);

            // Determine the type of date
            $date_type = '';
            if(!$release_date || $date_time < strtotime('2020-01-01')) {
                $date_type = 'old_or_undefined';
            } elseif($date_time > strtotime($current_time)) {
                $date_type = 'future';
            } else {
                $date_type = 'past';
            }
            // Assigning $date_display based on the date type
            switch($date_type) {
                case 'future':
                    $date_display = $future_phrases[array_rand($future_phrases)];
                    $marker_color = 'secondary-3';
                    $line_color = 'info-4';
                    $icon_color = 'secondary-3';
                    break;
                case 'past':
                    $date_display = date("F Y", $date_time);
                    $marker_color = 'accent-n3';
                    $line_color = 'info-2';
                    $icon_color = 'primary';
                    ++$i;
                    break;
                case 'old_or_undefined':
                    $date_display = $past_phrases[array_rand($past_phrases)];
                    $marker_color = 'accent-n3';
                    $line_color = 'info-2';
                    $icon_color = 'primary';
                    ++$i;
                    break;

            }

            $class = ($date_type === 'future') ? 'futurepost' : 'pastpost';


            // Different content based on post type
            $content = '';
            $icon = '';
            $CTA_text = '';
            switch(get_post_type()) {
                case 'milestones':
                    $content = get_the_content();
                    $icon = 'fa-bookmark';
                    break;
                case 'videos':
                    $content = get_field('teaser_message');
                    $icon = 'fa-film';
                    $CTA_text = 'Watch';
                    break;
                case 'pressreleases':
                    $content = get_field('teaser_message');
                    $icon = 'fa-newspaper';
                    $CTA_text = 'Read';
                    break;
            }
            $icon_stack = "<span class='fa-stack font_3 float_right c_{$icon_color}'>
                                <i class='fa-solid fa-circle fa-stack-2x'></i>
                                <i class='fa-solid {$icon} fa-stack-1x fa-inverse'></i>
                            </span>";

            // Building the output
            if ($i % 2 == 0) {
                //right
                $container_column = "col-start_2:md col-end_4:md col-start_1 col-end_3";
                $timeline_column = "col-start_1:md col-end_2:md col-start_2 col-end_3";
                $dot_column ="col-start_1:md col-end_2:md col-start_2 col-end_3";
                $content_column ="col-start_2:md col-end_end:md col-start_start col-end_2";
                $marker_direction = "flex_row:md flex_row-reverse";
            } else {
                //left
                $container_column = "col-start_1 col-end_3";
                $timeline_column = "col-start_2 col-end_3";
                $dot_column ="col-start_2 col-end_3";
                $content_column ="col-start_start col-end_2";
                $marker_direction = "flex_row-reverse";
            }
            $output .= "<section class='grid isolation_isolate {$class} | {$container_column} rows_2' style=' grid-row:span 2; grid-template-columns: subgrid;'>";
            $output .= "<div data-label='timeline-line' class='overflow_hidden {$timeline_column}  items_center row-start_1  row-end_3 flex flex_column items_center'>
                            <span class='bg_{$line_color} p-l_2' style='height:100%;'><span>
                        </div>";
            $output .= "<div data-label='timeline-dot' class='{$dot_column} row-start_1 row-end_2 grid items_center justify_center'>{$icon_stack}</div>";
            $output .= "<div data-label='timeline-marker' class='flex {$marker_direction} | col-end_3 col-start_1 row-end_2 row-start_1'>";
            $output .= "<span class='flex_grow p_1 self_center | bg_{$marker_color} m-l_3'></span>";
            $output .= "<strong class='date lh_0 self_center font_bold opacity_8 font_n2 font_n1:md | c_{$marker_color} p-l_3 '>{$date_display}</strong>";
            $output .= "</div>";
            $output .= "<div data-label='content' class='reading-typography p_3 | {$content_column}'>";
            $output .= "<h4 class='inline c_{$icon_color}'>".get_the_title()."</h4>";
            if($date_type !== 'future') {
                $output .= "<p>{$content}</p>";
                if($CTA_text !== ''){
                    $output .= "<a href='".get_permalink()."'>{$CTA_text} <i class='p-l_3 fa-sharp fa-solid fa-arrow-right'></i></a>";
                }
            }
            $output .= "</div>";
            $output .= "</section>";
        }
        wp_reset_postdata();
    } else {
        $output .= "<p>No posts found.</p>";
    }
    $output .= "</div>";
    return $output;
}
add_shortcode('timeline', 'custom_timeline_shortcode');