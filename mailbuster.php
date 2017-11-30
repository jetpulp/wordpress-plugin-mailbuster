<?php
/*
Plugin Name: Mailbuster for WordPress
Plugin URI: https://github.com/jetpulp/wordpress-plugin-mailbuster
Description: Trap emails and send them to a unique email address
Version: 0.1
Author: Mathias Delantes / JETPULP
Author URI: https://www.jetpulp.fr
Text Domain: mailbuster
Domain Path: /languages
License: GPL v2

Mailbuster for WordPress
Copyright (C) 2017, JETPULP
 
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

if ( ! class_exists( 'MailbusterPlugin' ) ) :
  
final class MailbusterPlugin {
  
  public 
    $plugin_url,
    $plugin_path
  ;
  
  public static function init() 
  {
    $plugin = new MailbusterPlugin();
    $plugin->plugin_setup(); 
  }
  
  public function plugin_setup() 
  {
    $this->plugin_url    = plugins_url( '/', __FILE__ );
    $this->plugin_path   = plugin_dir_path( __FILE__ );
    
    add_filter('wp_mail',array($this, 'redirect_mails'), 10,1);
    add_action( 'admin_notices', array($this, 'my_error_notice') );
    add_action( 'admin_menu', array($this, 'menu_setup' ) );  
    add_action( 'admin_init', array($this, 'register_settings') );
    load_plugin_textdomain( 'mailbuster', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
  }
  
  public function menu_setup() {
    add_options_page( 'Mailbuster for Wordpress', 'Mailbuster', 'manage_options', 'mailbuster-settings', array($this, 'settings_page' ) );
    add_submenu_page( null, 'Mailbuster for Wordpress', 'Mailbuster Test', 'manage_options', 'mailbuster-test', array($this, 'test_page' ));
  }
  
  public function settings_page() {
    include $this->plugin_path.'/includes/settings.php';
  }
  
  public function test_page() 
  {    
    if($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
      if (!wp_verify_nonce( $_POST['_wpnonce'], 'mailbuster_test_action' ) ) {
        die( 'Failed security check' );
      }
      
      wp_mail( $_POST['to'], __( 'Mailbuster Plugin for Wordpress', 'mailbuster' ), $_POST['message']);
    }
      
    include $this->plugin_path.'/includes/test.php';
  }
  
  public function register_settings() 
  {
    register_setting( 'mailbuster-settings', 'mailbuster_enabled' );
    register_setting( 'mailbuster-settings', 'mailbuster_to' );
    register_setting( 'mailbuster-settings', 'mailbuster_subject' );
    register_setting( 'mailbuster-settings', 'mailbuster_preproduction_pattern' );

  }
  
  /**
   * https://developer.wordpress.org/reference/hooks/wp_mail/
   */
  public function redirect_mails($args) 
  {
    if(get_option('mailbuster_enabled', false))
    {
      $to       = $args['to'];
      $subject  = $args['subject'];

      if(is_array($to)) {
        $to = implode(',', $to);
      }

      $args['to']       = get_option('mailbuster_to');
      $args['subject']  = trim(get_option('mailbuster_subject') .  " " . $subject . " (" . $to . ")");
    }

    return $args;
  }

  public function my_error_notice() {
    if(get_option('mailbuster_enabled', false))
    {
      $isPreprod = false;

      $domains = explode(',', get_option('mailbuster_preproduction_pattern'));
      foreach($domains as $domain) {
        $domain = trim($domain);
        if($domain != '' && strpos($_SERVER['HTTP_HOST'], $domain) !== FALSE) {
          $isPreprod = true;
        }
      }

      if($isPreprod) {
 ?>
     <div class="updated notice">
        <p><?php _e( 'Mailbuster is activated. This server is a Preproduction server.', 'mailbuster_textdomain' ); ?></p>
    </div>
 <?php       
      }
      else {
 ?>
     <div class="error notice">
        <p><?php _e( 'Mailbuster is activated. This server is a Production server. You must deactivate the plugin!', 'mailbuster_textdomain' ); ?></p>
    </div> 
 <?php       
      }
    }    
  }
}

add_action( 'plugins_loaded', array( 'MailbusterPlugin', 'init' ) );

endif;