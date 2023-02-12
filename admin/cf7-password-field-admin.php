<?php
class CF7_Password_Field
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('admin_notices', array($this, 'display_admin_notice'));
        add_action( 'wpcf7_init', array($this,'wpcf7_add_shortcode_password' ));
      //  add_action( 'wpcf7_admin_init', array($this,'wpcf7_add_tag_generator_password', 55 ));
    }

    public function enqueue_scripts()
    {
        if (self::is_cf7_form_page()) {
            wp_enqueue_script('cf7-password-field', CF7_PASSWORD_FIELD_ASSETS . 'js/wpcf7-password.js', array('jquery'), '1.0', true);
            wp_enqueue_style('cf7-password-field', CF7_PASSWORD_FIELD_ASSETS . 'css/wpcf7-password.css');
        }
    }
    public function display_admin_notice()
    {
        if (!is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
?>
            <div class="notice notice-error">
                <p>Secure Password Field plugin requires Contact Form 7 plugin to be active.</p>
            </div>
        <?php
        }
    }

    public static function is_cf7_form_page()
    {

        global $post;
        if ($post instanceof WP_Post && has_shortcode($post->post_content, 'contact-form-7')) {
            return true;
        }
        return false;
    }

    public function wpcf7_add_shortcode_password() {
        wpcf7_add_shortcode( 'password', array($this,'wpcf7_password_shortcode_handler' ));
    }

    public function wpcf7_password_shortcode_handler( $tag ) {

        $validation_error = wpcf7_get_validation_error( $tag->name );
    
        $class = wpcf7_form_controls_class( $tag->type );
    
        if ( $validation_error ) {
            $class .= ' wpcf7-not-valid';
        }
    
        $atts = array();
    
        $atts['size'] = $tag->get_size_option( '40' );
        $atts['maxlength'] = $tag->get_maxlength_option();
        $atts['minlength'] = $tag->get_minlength_option();
    
        if ( $atts['maxlength'] && $atts['minlength'] && $atts['maxlength'] < $atts['minlength'] ) {
            unset( $atts['maxlength'], $atts['minlength'] );
        }
    
        $atts['class'] = $tag->get_class_option( $class );
        $atts['id'] = 'cf7password';
        $atts['tabindex'] = $tag->get_option( 'tabindex', 'int', true );
    
        $atts['type'] = 'password';
        $atts['name'] = 'your-password';
        $atts['value'] = '';
        $atts['autocomplete'] = 'off';
        $atts['onkeyup'] = 'cf7checkPasswordStrength()';
    
        $atts = wpcf7_format_atts( $atts );
    
        $html = sprintf(
            '<span class="wpcf7-form-control-wrap %1$s"><input %2$s />%3$s</span><div id="passwordStrength" class="passwordStrength">Password Strength: <span></span></div>
            <div class="progress">
              <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>',
        sanitize_html_class( $tag->name ), $atts, $validation_error );
    
        return $html;
    }

   

  
}
new CF7_Password_Field();
