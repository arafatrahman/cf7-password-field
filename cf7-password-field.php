<?php
/*
Plugin Name: Contact Form 7 Custom Password Field
Description: Adds a custom password field to Contact Form 7
Version: 1.0
Author: Arafat Rahman
*/

add_action( 'wpcf7_init', 'wpcf7_add_shortcode_password' );

function wpcf7_add_shortcode_password() {
    wpcf7_add_shortcode( 'password', 'wpcf7_password_shortcode_handler' );
}

function wpcf7_password_shortcode_handler( $tag ) {

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
    $atts['id'] = 'mypassword';
    $atts['tabindex'] = $tag->get_option( 'tabindex', 'int', true );

    $atts['type'] = 'password';
    $atts['name'] = 'your-password';
    $atts['value'] = ' ';
    $atts['autocomplete'] = 'off';
    $atts['onkeyup'] = 'cf7checkPasswordStrength()';

    $atts = wpcf7_format_atts( $atts );

    $html = sprintf(
        '<span class="wpcf7-form-control-wrap %1$s"><input %2$s />%3$s</span><div id="passwordStrength"></div>',
        sanitize_html_class( $tag->name ), $atts, $validation_error );

    return $html;
}

add_action( 'wpcf7_admin_init', 'wpcf7_add_tag_generator_password', 55 );

function wpcf7_add_tag_generator_password() {
    $tag_generator = WPCF7_TagGenerator::get_instance();
    $tag_generator->add( 'password', __( 'password', 'contact-form-7' ),
        'wpcf7_tag_generator_password' );
}

function wpcf7_tag_generator_password( $contact_form, $args = '' ) {
    $args = wp_parse_args( $args, array() );

    $description = __( "Generates a password field. For better security, it is recommended to use this field in combination with JavaScript encryption.", 'contact-form-7' );

?>
    <div class="control-box">
        <fieldset>
            <legend><?php echo sprintf( esc_html( $description ), 'wpcf7-password' ); ?></legend>

            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>">
                                <?php echo esc_html( __( 'Name', 'contact-form-7' ) ); ?>
                            </label>
                        </th>
                        <td>
                            <input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" />
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="<?php echo esc_attr( $args['content'] . '-id' ); ?>">
                                <?php echo esc_html( __( 'Id attribute', 'contact-form-7' ) ); ?>
                            </label>
                        </th>
                        <td>
                            <input type="text" name="id" class="idvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-id' ); ?>" />
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="<?php echo esc_attr( $args['content'] . '-class' ); ?>">
                                <?php echo esc_html( __( 'Class attribute', 'contact-form-7' ) ); ?>
                            </label>
                        </th>
                        <td>
                            <input type="text" name="class" class="classvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-class' ); ?>" />
                        </td>
                    </tr>

                </tbody>
            </table>
        </fieldset>
    </div>

    <div class="insert-box">
        <input type="text" name="password" class="tag code" readonly="readonly" onfocus="this.select()" />

        <div class="submitbox">
            <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
        </div>

        <br class="clear" />
    </div>
<?php
}


// Register and enqueue the password strength meter script
function wpcf7_password_enqueue_scripts() {
    wp_register_script( 'wpcf7-password-strength-meter', plugins_url( '/wpcf7-password.js', __FILE__ ), array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'wpcf7-password-strength-meter' );
}

add_action( 'wp_enqueue_scripts', 'wpcf7_password_enqueue_scripts' );

