<?php

/**
 * Plugin Name: Better Ads
 * Plugin URI:
 * Description: Manages Your Ad in your posts in the simpliest way
 * Author: Mehedee Hasan
 * Version: 1.0
 * Author URI:
 */


// create custom plugin settings menu
add_action('admin_menu', 'admaster_menu');

function admaster_menu() {

    //create new top-level menu
    add_menu_page('Better Ads', 'Better Ads', 'administrator', __FILE__, 'ba_settings_page','dashicons-media-document');

    //call register settings function
    add_action( 'admin_init', 'ba_register_settings' );
}


function ba_register_settings() {
    //register our settings
    register_setting( 'ba-settings-group', 'ba_adsense_code' );

}

function ba_settings_page() {
    ?>
    <div class="wrap">
        <h2>Better Ads Settings</h2>
        <p>Enter and save your ad code below. The corresponding will be shown within your posts then. </p>

        <form method="post" action="options.php">
            <?php settings_fields( 'ba-settings-group' ); ?>
            <?php do_settings_sections( 'ba-settings-group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Paste Your Code Here:</th>
                    <td><textarea name="ba_adsense_code" cols="90" rows="5"> <?php echo esc_attr( get_option('ba_adsense_code') ); ?></textarea> </td>
                </tr>

            </table>

            <?php submit_button(); ?>

        </form>
    </div>
<?php }

add_filter('the_content', 'ba_ad_placement');

function ba_ad_placement($content){
    if(is_single()){
        $code = "<div style='margin-right: 10px; float: left;'> " . get_option('ba_adsense_code') . "</div>";
        $arr = explode(' ', $content);
        $counter= count($arr); //getting the total number of
        array_splice($arr, $counter/2, 0, array($code));
        $content = implode(' ', $arr);
    }
    return $content;
}

