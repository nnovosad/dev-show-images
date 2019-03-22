<?php

class DSILoad
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', function () {
            $script_params = array(
                'url' => get_option('dsi_option')['production_server']
            );

            wp_enqueue_script('dsi-js', plugins_url('assets/js/dev-show-images.js', __DIR__), null, null, true);
            wp_localize_script('dsi-js', 'productionServerUrl', $script_params);
        }, 99999);

    }
}