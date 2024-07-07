<?php

/**
 * Ensures that the module init file can't be accessed directly, only within the application.
 */

defined('BASEPATH') or exit('No direct script access allowed');
// require(__DIR__ . '/vendor/autoload.php');

/*
Module Name: Custom Fields Group
Description: Custom Fields Group Management.
Version: 2.3.0
Requires at least: 2.3.*
*/

define('CFG_MODULE_NAME', 'cfg_module');

$CI = &get_instance();

register_activation_hook(CFG_MODULE_NAME, 'cfg_module_activation_hook');

register_language_files(CFG_MODULE_NAME, [CFG_MODULE_NAME]);

function cfg_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php'); 
}

/**
* Register module deactivation hook
* @param  string $module   module system name
* @param  mixed $function  function for the hook
* @return mixed
*/

    $CI = &get_instance();
    $CI->load->helper(CFG_MODULE_NAME . '/cfg');

    hooks()->add_action('admin_init', 'cfg_module_admin_init_menu_item');

    function cfg_module_admin_init_menu_item()
    {
    /**
        * If the logged in user is administrator, add custom menu in main menu
        */

        if (is_admin()) {
            $CI = &get_instance();

            if ( is_admin() ) {

                $CI->app_menu->add_sidebar_menu_item('cfg_module', [
                    'name'     => "Custom Fields Group",
                    'icon'     => 'fa fa-crosshairs', 
                    'href'     => admin_url('cfg_module/ll_home'),              
                    'position' => 49,
                ]);

            }
        }
    }

        
