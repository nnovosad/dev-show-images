<?php
/*
Plugin Name: Dev Show Images
Description: Simple plugin to display photos from the production server if they are not locally or stage
*/

require_once 'includes/admin/DSISettingsPage.php';
require_once 'includes/DSILoad.php';

if( is_admin() ) {
    $dsi_settings_page = new DSISettingsPage();
} else {
    $dsi_load = new DSILoad();
}

