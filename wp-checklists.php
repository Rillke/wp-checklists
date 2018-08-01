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

/**
 * **********************************************************************
 *
 * Add global JavaScript file to page.
 *
 * **********************************************************************
 */

// not working for customer with broken theme
add_action( 'wp_enqueue_scripts', 'wpcl_global_script' );
function wpcl_global_script()
{
    // Register and enqueue global script to footer
    wp_register_script( 'wpcl_global_script', plugins_url( '/js/global.js', __FILE__ ), [ 'jquery' ], null, true );
    wp_enqueue_script( 'wpcl_global_script' );
    // Register and enqueue global stylesheet
    wp_register_style( 'wpcl_global_script', plugins_url( '/css/global.css', __FILE__ ) );
    wp_enqueue_style( 'wpcl_global_script' );
}


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
            $url = plugins_url() . '/wp-checklists';

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
        $content .= 'if (window.QTags) QTags.addButton( "btn1", "check list", "<div class=\"wpcl-checklist\">", "</div>" );';
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
    $buttons[] = 'wpcl_button';

    return $buttons;
}

/**
 * Register TinyMCE Plugin
 */
function wpcl_add_plugin($plugin_array)
{
    $url = plugins_url() . "/wp-checklists";

    $plugin_array['wpcl_button'] = $url . '/js/button-checklist.js';

    return $plugin_array;
}


/**
 * Care for Advanced Custom Fields (ACF) plugin
 */

add_filter( 'acf/fields/wysiwyg/toolbars', 'continuums_wysiwyg_acf' );
function continuums_wysiwyg_acf( $acfToolbars ) {
    $acfToolbars['Basic']['1'][] = 'wpcl_button';
    //echo '<pre>';
    //print_r($acfToolbars);
    //echo '</pre>';
    //die;
    return $acfToolbars;
}

// ------------------

