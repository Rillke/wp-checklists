<?php
/*
 * Plugin Name: Check lists
 * Plugin URI: https://rillke.com/wp-checklists
 * Description: Create checklists from the editor
 * Version: 1.6.0.0
 * Author: Rainer Rillke, derived from Ola Eborn's work
 * Author URI: https://rillke.com
 * Text Domain: wp-checklists
 * License: GPL
 */
add_action('init', 'wpcl_editor_buttons');

function wpcl_editor_buttons()
{
    /**
     * **********************************************************************
     *
     * Adds a filter to append the default stylesheet to the tinymce editor.
     *
     * **********************************************************************
     */
    if (! function_exists('wpcl_tdav_css')) {

        function wpcl_tdav_css($wp)
        {
            $url = plugins_url() . "/wp-checklists";

            $wp .= ',' . $url . '/css/editor-style.css';
            return $wp;
        }
    }
    add_filter('mce_css', 'wpcl_tdav_css');
}

/**
 * **********************************************************************
 *
 * Add HTML-Editor Button
 *
 * **********************************************************************
 */
if (! function_exists('wpcl_quicktags')) {

    function wpcl_quicktags()
    {
        $content = '<script type="text/javascript">';
        $content .= 'QTags.addButton( "btn1", "check list", "<div class=\"wpcl-checklist\">", "</div>" );';
        $content .= '</script>';
        echo $content;
    }
    add_action('admin_print_footer_scripts', 'wpcl_quicktags');
}

// -----

/**
 * **********************************************************************
 *
 * Add Checklist Button
 *
 * **********************************************************************
 */

add_action('admin_init', 'wpcl_add_buttons');

/**
 * Create Our Initialization Function
 */
function wpcl_add_buttons()
{
    if (! current_user_can('edit_posts') && ! current_user_can('edit_pages')) {
        return;
    }

    if (get_user_option('rich_editing') == 'true') {
        add_filter('mce_external_plugins', 'wpcl_add_plugin');
        add_filter('mce_buttons', 'wpcl_register_button');
    }
}

/**
 * Register Button
 */
function wpcl_register_button($buttons)
{
    $count_posts = wp_count_posts('wpcl_editor_buttons');
    $count_posts = $count_posts->publish;

    $buttons[] = 'wpcl_button';

    return $buttons;
}

/**
 * Register TinyMCE Plugin
 */
function wpcl_add_plugin($plugin_array)
{
    $url = plugins_url() . "/wp-checklists";

    $plugin_array['wpcl_button'] = $url . '/js/button-1-1.js';

    return $plugin_array;
}

// ------------------

