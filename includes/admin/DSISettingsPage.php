<?php
class DSISettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );

        add_action( 'admin_enqueue_scripts', function ($hook) {
            if ($hook == 'settings_page_setting-dev-show-image') {
                wp_enqueue_style('dsi-styles', plugins_url('assets/css/style.css', dirname(__FILE__, 2) ));
            }
        });
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Dev Show Images',
            'Dev Show Images',
            'manage_options',
            'setting-dev-show-image',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'dsi_option' );
        ?>
        <div class="wrap">
            <h1>Development Show Images</h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'dsi_option_group' );
                do_settings_sections( 'setting-dev-show-image' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'dsi_option_group', // Option group
            'dsi_option', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'setting-dev-show-image' // Page
        );

        add_settings_field(
            'production_server',
            'Production Server Url',
            array( $this, 'production_server_callback' ),
            'setting-dev-show-image',
            'setting_section_id'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();

        if( isset( $input['production_server'] ) )
            $new_input['production_server'] = sanitize_text_field( $input['production_server'] );

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
//        print 'Enter your settings below:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function production_server_callback()
    {
        printf(
            '<input type="url" id="production_server" class="dsi_input" name="dsi_option[production_server]" value="%s" />',
            isset( $this->options['production_server'] ) ? esc_attr( $this->options['production_server']) : ''
        );
    }
}