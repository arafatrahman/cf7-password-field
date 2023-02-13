<?php
/*
Plugin Name: Secure Password Field for CF7
Description: This plugin adds a secure password field to Contact Form 7, making it easy to add password fields to your forms and improve the security of your website. Compatible with Contact Form 7 and fully customizable.
Version: 1.0.0
Author: AR Riyad 
Author URI:  https://github.com/arafatrahman
*/


define( 'CF7_PASSWORD_FIELD_ASSETS', plugin_dir_url( __FILE__ ) . 'admin/assets/');


function cf7_password_field_plugin_load(){
    require_once( plugin_dir_path( __FILE__ ) . 'admin/cf7-password-field-admin.php' );
}

add_action('plugins_loaded', 'cf7_password_field_plugin_load');


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
