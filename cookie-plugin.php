<?php
/**
 * @package Hello_Dolly
 * @version 1.6
 */
/*
Plugin Name: Reddico Cookie Compliancy
Plugin URI: http://reddico.co.uk/resources
Description: Bring your site up to date with GDPR compliancy legistlation with our cookie policy plugin.
Author: Reddico
Version: 1.1
Author URI: http://reddico.co.uk
*/

class cookiePlugin {
    static function install() {
        // Bail if activating from network, or bulk
        if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
            return;
        }
    }

    static function init_cookiebar(){
    $plugindir = plugin_dir_url( __FILE__ );
    $accepted = false;
    if (isset($_COOKIE['cookies_accepted']) && $_COOKIE['cookies_accepted'] == 'true'){
        $accepted = true;
    }
    ?>
    <div class="cookie_container bottom left">

    <div class="rdco cookie_bar animated fadeIn" id="cookie-container">
        <?php if($accepted != true){ ?>
        <div class="cookie_content" id="cookie-content">
            <h3>If you dig cookies, come on in!</h3>
            <p class="large">Protecting and managing your online privacy</p>
            <p><b>TLDR:</b> We use cookies to improve the site experience and perform traffic analytics. We're fully compliant with UK and EU data protection laws.</p>
            <h6>How we use cookies</h6>
            <ul>
                <li>Track how visitors interact with our website pages.</li>
                <li>Understand how long visitors spend on certain pages.</li>
                <li>Improve the site experience with preference options.</li>
                <li>Verify human users from bots.</li>
            </ul>
            <p class="small"><i>Review our <a href="<?php echo home_url('privacy'); ?>"> cookie policy</a></i></p>
            <hr>
            <a class="rdco_btn" href="<?php echo $plugindir; ?>leave.php">Get me outta here</a>
            <a class="rdco_btn right primary" onclick="acceptCookies(this)">I like cookies <i class="rdco-icon icon-check">&#xe802;</i></a>
        </div><!-- end cookie content area -->
        <?php } ?>
    </div><!-- end cookie bar -->

    <div class="rdco cookie_bar cookie_prefs" id="cookie-prefs" style="display:none;">
        <div class="cookie_content" id="cookie-content">
            <h4>Don't like Cookies?</h4>
            <a class="close_btn" onclick="toggleCookiePrefs(this)"><img src="<?php echo $plugindir; ?>/assets/img/close-symbol.png" alt="close" width="14" height="14"></a>
            <p class="large">To leave this site and remove all cookies, choose the option below.</p>
            <p class="small"><i>Review our <a href="<?php echo home_url('privacy'); ?>">cookie policy</a></i></p>
            <hr>
            <a class="rdco_btn" onclick="toggleCookiePrefs(this)">I changed my mind</a>
            <a class="rdco_btn right" href="<?php echo $plugindir; ?>leave.php">Get me outta here <i class="rdco-icon icon-logout">&#xe801;</i></a>
        </div><!-- end cookie content area -->
    </div><!-- end cookie prefs area -->

    <a onclick="toggleCookiePrefs(this)" class="cookie_toggle" id="cookie-toggle" <?php if($accepted != true){ ?> style="display:none;" <?php } ?>><object data="<?php echo $plugindir; ?>/assets/img/cookie-symbol.svg" type="image/svg+xml" width="32" height="32" fill="green"></object><span>Click me to change your cookie preferences</span></a>
        
    </div><!-- end cookie container -->
<?php }
    
    static function plugin_assets_load(){
        $plugindir = plugin_dir_url( __FILE__ );

        /*** LOAD CSS **/
        // Register:
        wp_register_style( 'cookie-style', $plugindir . '/assets/css/cookie-plugin.css');
        // Enqueue:
        wp_enqueue_style( 'cookie-style' );

        /*** LOAD JS **/
        // Register:
        wp_register_script( 'cookie-script', $plugindir . '/assets/js/cookie-plugin.js', array( 'jquery') );
        // Localize:
        wp_localize_script( 'cookie-script', 'regObject', array( 
           'ajaxurl' => admin_url( 'admin-ajax.php' ),
           'homeurl' => home_url(),
       )); 
        // Enqueue:
        wp_enqueue_script( 'cookie-script' );
    }

    static function register_cookie_menu() {
      add_management_page(
        'Cookie compliancy options',
        'Cookie compliancy',
        'read',
        'reddico-cookie-options',
        array( 'cookiePlugin', 'cookie_admin_page')
      );
    }
    
    public static function register_my_cool_plugin_settings() {
        //register our settings
        register_setting( 'my-cool-plugin-settings-group', 'new_option_name' );
        register_setting( 'my-cool-plugin-settings-group', 'some_other_option' );
        register_setting( 'my-cool-plugin-settings-group', 'option_etc' );
    }
    
    static function cookie_admin_page() {
        $plugindir = plugin_dir_url( __FILE__ );    
    ?>
      <div class="wrap">
          <div class="rdco_panel welcome_msg">
              <div class="panel_body">
                <div class="media">
                    <img src="<?php echo plugins_url('/assets/img/logo-min.png', __FILE__); ?>">
                </div>
                <div class="content">
                    <h1>Reddico Cookie Compliancy</h1>
                    <p>(The old man laughs as Marty runs into the Saloon.) Doc! Doc! (He sees the glass.) What're you doin'?</p>
                    <hr>
                    <p class="small">Pretty Mediocre photographic fakery, they cut off your brother's hair. (He tosses the photo back at Marty.) I'm telling the truth, Doc, you gotta believe me. So tell me, future boy, who's president of the United States in 1985? Ronald Reagan.</p>
                </div>
              </div><!-- end panel body -->
          </div><!-- end panel welcome msg -->
          <?php if($x != null){ ?>
          <div class="grid-container">
              <div class="grid-row">
                <div class="grid-col">
                    <div class="rdco_panel options">
                        <div class="panel_heading"><h4>Text Options</h4></div>
                        <div class="panel_body">
                            <form method="post" action="options.php">
                                <?php settings_fields( 'my-cool-plugin-settings-group' ); ?>
                                <?php do_settings_sections( 'my-cool-plugin-settings-group' ); ?>
                                <table class="form-table">
                                    <tr valign="top">
                                    <th scope="row">New Option Name</th>
                                    <td><input type="text" name="new_option_name" value="<?php echo esc_attr( get_option('new_option_name') ); ?>" /></td>
                                    </tr>

                                    <tr valign="top">
                                    <th scope="row">Some Other Option</th>
                                    <td><input type="text" name="some_other_option" value="<?php echo esc_attr( get_option('some_other_option') ); ?>" /></td>
                                    </tr>

                                    <tr valign="top">
                                    <th scope="row">Options, Etc.</th>
                                    <td><input type="text" name="option_etc" value="<?php echo esc_attr( get_option('option_etc') ); ?>" /></td>
                                    </tr>
                                </table>

                                <?php submit_button(); ?>

                            </form>
                        </div><!-- end panel body -->
                    </div><!-- end panel options -->
                    <div class="rdco_panel options">
                        <div class="panel_heading"><h4>Appearance</h4></div>
                        <div class="panel_body">
                            <p>(Marty is in the bathroom changing into western style clothing while Doc is outside putting last minute touches on the Delorean.) The clothes fit? (os) Yeah! Everything except the boots, Doc. They're kind of tight! I dunno, are you sure this stuff is authentic? Of course. Haven't you ever seen a Western? (Marty comes out of the bathroom and he's dressed in a frilly pink western shirt and red-ish pants that look very un-authentic.)</p>
                        </div><!-- end panel body -->
                    </div><!-- end panel options -->
                </div><!-- end col -->
                <div class="grid-col">
                    <div class="rdco_panel options">
                        <div class="panel_heading"><h4>Preview</h4></div>
                        <div class="panel_body">
                            <p>(Marty is in the bathroom changing into western style clothing while Doc is outside putting last minute touches on the Delorean.) The clothes fit? (os) Yeah! Everything except the boots, Doc. They're kind of tight! I dunno, are you sure this stuff is authentic? Of course. Haven't you ever seen a Western? (Marty comes out of the bathroom and he's dressed in a frilly pink western shirt and red-ish pants that look very un-authentic.)</p>
                        </div><!-- end panel body -->
                    </div><!-- end panel options -->
                </div><!-- end col -->
              </div><!-- end row -->
          </div><!-- end container -->
          <?php } ?>
      </div><!-- end wrap -->
      <?php }
    
    function load_cookie_admin_style($hook) {
        if($hook != 'tools_page_reddico-cookie-options') {
            return;
        }
        wp_enqueue_style( 'cookie-option-css', plugins_url('/assets/css/cookie-admin.css', __FILE__) );
    }
}

add_action( 'admin_enqueue_scripts', array( 'cookiePlugin', 'load_cookie_admin_style') );

add_action('admin_menu', array( 'cookiePlugin', 'register_cookie_menu') );

add_action( 'wp_footer', array( 'cookiePlugin', 'init_cookiebar' ) );

add_action( 'wp_enqueue_scripts', array( 'cookiePlugin', 'plugin_assets_load' ) );

register_activation_hook( __FILE__, array( 'cookiePlugin', 'install' ) );

?>
