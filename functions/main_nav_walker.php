<?php 
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