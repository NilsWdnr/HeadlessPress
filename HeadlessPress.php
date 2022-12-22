<?php

/**
 * @package HeadlessPress
 */
/*
Plugin Name: HeadlessPress
Description: Disables everything related to the frontend provided by WordPress. Makes WordPress a complete headless CMS.
Version: 1.0.0
Author: Nils Weidner
Text Domain: HeadlessPress
*/

function remove_menus()
{
    remove_menu_page('themes.php');
}

add_action('admin_menu', 'remove_menus');

function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

function remove_frontend()
{
    if (!is_admin() && ! is_login_page() && !strpos($_SERVER['REQUEST_URI'], 'wp-json')) {
        echo "Access denied";
        die;
    }
}

function menu_init()
{
    require_once('inc/settingsTemplate.php');
}

function setup_menu_page()
{
    add_menu_page( 'API settings', 'API settings', 'manage_options', 'API settings', 'menu_init','dashicons-rest-api' );

    register_setting("api_settings", "allow_install_plugins",['default'=>false]);
}

add_action('after_setup_theme', 'remove_frontend');
add_action('admin_menu','setup_menu_page');
