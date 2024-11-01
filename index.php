<?php
/*
Plugin Name: wp-admin Logo Customization
Plugin URI: http://ruhulamin.me
Description: Change Your Wp-Admin, wp-login Logo
Version: 1.0.0
Author: Ruhul Amin
Author URI: http://www.ruhulamin.me
License: GPL2*/
function arllc_get_default_options() {
	$options = array(
		'logo' => ''
	);
	return $options;
}
add_action('admin_menu','arllcplugin_option');


//create dashboard option page
function arllcplugin_option(){
   add_dashboard_page('Login Logo Options', 'Logo Options', 'read', 'wp-logo-customization', 'arllc_admin_options_page');
}

function arllc_admin_options_page(){ ?>
    				<div class="wrap">
			
			<div id="icon-themes" class="icon32"><br /></div>
		
			<h2><?php _e( 'Login logo Options', 'arllc' ); ?></h2>
			
			<!-- If we have any error by submiting the form, they will appear here -->
			<?php settings_errors( 'arllc-settings-errors' ); ?>
			
			<form id="form-arllc-options" action="options.php" method="post" enctype="multipart/form-data">
			
				<?php
					settings_fields('plugin_arllc_options');
					do_settings_sections('arllc');
				?>
				<p class="submit">
					<input name="plugin_arllc_options[submit]" id="submit_options_form" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'arllc'); ?>" />
					<input name="plugin_arllc_options[reset]" type="submit" class="button-secondary" value="<?php esc_attr_e('Reset Defaults', 'arllc'); ?>" />		
				</p>
			
			</form>
			
		</div>
<?php
}
    function arllc_options_settings_init() {  
        
        register_setting( 'plugin_arllc_options', 'plugin_arllc_options', 'arllc_options_validate' );  
      
        // Add a form section for the Logo  
        add_settings_section('arllc_settings_header', __( 'Logo Options', 'arllc' ), 'arllc_settings_header_text', 'arllc');  
      
        // Add Logo uploader  
        add_settings_field('arllc_setting_logo',  __( 'Logo', 'arllc' ), 'arllc_setting_logo', 'arllc', 'arllc_settings_header');
        
            // Add Current Image Preview  
    add_settings_field('arllc_setting_logo_preview',  __( 'Logo Preview', 'arllc' ), 'arllc_setting_logo_preview', 'arllc', 'arllc_settings_header');  
    
        }  
    add_action( 'admin_init', 'arllc_options_settings_init' );  
      
    function arllc_settings_header_text() {  
        ?>  
            <p><?php _e( 'Manage Logo Options for Wp-admin panel.', 'arllc' ); ?></p>  
        <?php  
    }  
      
    function arllc_setting_logo() {  
        $arllc_options = get_option( 'plugin_arllc_options' );  
        ?>  
            <input type="text" id="logo_url" name="plugin_arllc_options[logo]" value="<?php echo esc_url( $arllc_options['logo'] ); ?>" />  
            <input id="upload_logo_button" type="button" class="button" value="<?php _e( 'Upload Logo', 'arllc' ); ?>" />  
            <span class="description"><?php _e('Upload an image for the logo(Size should be 350pxX67px).', 'arllc' ); ?></span>  
        
        <?php  
    }  
    
        function arllc_options_validate( $input ) {  
        $default_options = arllc_get_default_options();  
        $valid_input = $default_options;  
      
        $submit = ! empty($input['submit']) ? true : false;  
        $reset = ! empty($input['reset']) ? true : false;  
      
        if ( $submit )  
            $valid_input['logo'] = $input['logo'];  
        elseif ( $reset )  
            $valid_input['logo'] = $default_options['logo'];  
      
        return $valid_input;  
    }  
    function my_enqueue() {

    wp_enqueue_script( 'my_custom_script', plugins_url('/js/arllc-upload.js', __FILE__),array('jquery','media-upload','thickbox','wp-color-picker') );
         wp_enqueue_script('jquery');  
      
            wp_enqueue_script('thickbox');  
            wp_enqueue_style('thickbox');  
      
            wp_enqueue_script('media-upload');  
            wp_enqueue_script('arllc-upload'); 
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_style( 'farbtastic' );
    wp_enqueue_script( 'farbtastic' );
}

add_action( 'admin_enqueue_scripts', 'my_enqueue' );


    // Print logo on backend
    function arllc_setting_logo_preview() {  
        $arllc_options = get_option( 'plugin_arllc_options' );  ?>  
        <div id="upload_logo_preview" style="min-height: 100px;">  
            <img style="max-width:100%;" src="<?php echo esc_url( $arllc_options['logo'] ); ?>" />  
        </div>  
        <?php  
    }  

    // Update/Replace logo on admin area
    function arllc_custom_login_logo() {
    $arllc_options = get_option( 'plugin_arllc_options' );
    $logourl = esc_url($arllc_options['logo']);
$backgroundurl = get_option('background_custom_url');
     echo '<style type="text/css">                                                                   
         h1 a { background-image:url('.$logourl.') !important; 
         height: 65px !important; width: 350px !important; margin-left: -12px !important;}                            
     </style>';
}
add_action('login_head', 'arllc_custom_login_logo');


