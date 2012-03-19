<?php
 /**
 * Plugin Name: Scripts
 * Plugin URI: https://github.com/onemanonelaptop/scripts
 * Description: Provides a central location to download and include some of the more common frontend javascript libraries. All javascript libraries are donwloaded/updated from their github repositories.
 * Version: 0.0.1
 * Author: Rob Holmes
 * Author URI: https://github.com/onemanonelaptop/
 */

/*  Copyright 2011 Rob Holmes (email : rob@onemanonelaptop.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// We are going to need this in a minute
global $wp_version;

// languages
load_plugin_textdomain( 'scripts', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

// Check some versions
if ( version_compare(PHP_VERSION, '5.2', '<') || version_compare($wp_version, '3.3', '<')  ) {
    if ( is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX) ) {
        require_once ABSPATH.'/wp-admin/includes/plugin.php';
        deactivate_plugins( __FILE__ );
        wp_die( sprintf( __('The scripts plugin requires PHP 5.2 or higher and WordPress 3.3 or higher. The plugin has now disabled itself. ' . $wp_version . ' ' . version_compare($wp_version, '3.3', '<'), 'scripts')) );
    } else {
        return;
    }
} // end if


/**
* Class Definition
*/
class Scripts  {
    
    /**
     *  @var array  An array of all the wordpress provided javascript handles
     */
    var $handles = array(
         'scriptaculous-root' => '',
         'scriptaculous-builder' => '',
         'scriptaculous-dragdrop' => '',
         'scriptaculous-effects' => '',
         'scriptaculous-slider' => '',
         'scriptaculous-sound' => '',
         'scriptaculous-controls' => '',
         'scriptaculous' => '',
         'jcrop' => '',
         'swfobject' => '',
         'swfupload' => '',
         'swfupload-degrade' => '',
         'swfupload-queue' => '',
         'swfupload-handlers' => '',
         'jquery' => '',
         'jquery-form' => '',
         'jquery-color' => '',
         'jquery-ui-core' => '',
         'jquery-ui-widget' => '',
         'jquery-ui-mouse' => '',
         'jquery-ui-accordion' => '',
         'jquery-ui-slider' => '',
         'jquery-ui-tabs' => '',
         'jquery-ui-sortable' => '',
         'jquery-ui-draggable' => '',
         'jquery-ui-droppable' => '',
         'jquery-ui-selectable' => '',
         'jquery-ui-datepicker' => '',
         'jquery-ui-resizable' => '',
         'jquery-ui-dialog' => '',
         'schedule' => '',
         'suggest' => '',
         'thickbox' => '',
         'jquery-hotkeys' => '',
         'sack' => '',
         'quicktags' => '',
         'farbtastic' => '',
         'tiny_mce' => '',
         'prototype' => '',
         'json2' => ''
    );
    
    /**
    * @var array Definitions of all the scripts and their remote download locations 
    */
    var $scripts = array(
        "qtip" => array(
            "title" => "qTip 2",
            "description" =>"The second generation of the advanced qTip plugin <a href='http://craigsworks.com/projects/qtip2/'>http://craigsworks.com/projects/qtip2/</a>",
            "js"=>array(
                "qtip2" => array(
                    "file" => "jquery.qtip.min.js",
                    "url" => "https://raw.github.com/Craga89/qTip2/master/dist/jquery.qtip.min.js"
                )
            ),
            "css"=>array(
                "qtip2" => array(
                    "file" => "jquery.qtip.min.css",
                    "url" => "https://raw.github.com/Craga89/qTip2/master/dist/jquery.qtip.min.css"
                )
            )
        ),
        "cycle" => array(
            "title" => "jQuery Cycle Full",
            "description" => "The full jquery cycle plugin with all the transition effects! <a target='_blank' href='http://jquery.malsup.com/cycle/'>http://jquery.malsup.com/cycle/</a>",
            "js"=>array(
                "cycle" => array(
                    "file" => "jquery.cycle.all.js",
                    "url" => "https://raw.github.com/malsup/cycle/master/jquery.cycle.all.js"
                )
            ),
            "css"=>array(),
            "other"=>array()
        ),
        "cycle-lite" => array(
            "title" => "jQuery Cycle Lite",
            "description" => "jQuery Cycle Lite, Fewer options but tiny file size! <a target='_blank' href='http://jquery.malsup.com/cycle/'>http://jquery.malsup.com/cycle/</a>",
            "js"=>array(
                "cycle-lite" => array(
                    "file" => "jquery.cycle.lite.js",
                    "url" => "https://raw.github.com/malsup/cycle/master/jquery.cycle.lite.js"
                )
            ),
            "css"=>array(),
            "other"=>array()
        ),
        "chosen" => array(
            "title" => "jQuery Chosen",
            "description" => "Chosen is a JavaScript plugin that makes long, unwieldy select boxes much more user-friendly. <a target='_blank' href='http://harvesthq.github.com/chosen/'>http://harvesthq.github.com/chosen/</a>",
            "js"=>array(
                "chosen" => array(
                    "file" => "chosen.jquery.min.js",
                    "url" => "https://github.com/harvesthq/chosen/blob/master/chosen/chosen.jquery.min.js"
                )
            ),
            "css"=>array( 
                "chosen" => array(
                    "file" => "chosen.css",
                    "url" => "https://raw.github.com/harvesthq/chosen/master/chosen/chosen.css"
                )
            ),
            "other"=>array( 
                "chosen-sprite" => array(
                    "file" => "chosen-sprite.png",
                    "url" => "https://github.com/harvesthq/chosen/raw/master/chosen/chosen-sprite.png"
                )
            )
        ),
        "placeholder" => array(
            "title" => "jQuery Placeholder",
            "description" => "HTML5 Placeholder jQuery Plugin <a target='_blank' href='https://github.com/mathiasbynens/jquery-placeholder'>https://github.com/mathiasbynens/jquery-placeholder</a>",
            "js"=>array(
                "placeholder" => array(
                    "file" => "jquery.placeholder.min.js",
                    "url" => "https://raw.github.com/mathiasbynens/jquery-placeholder/master/jquery.placeholder.min.js"
                )
            ),
            "css"=>array(),
            "other"=>array()
        ), 
        
        "jscrollpane" => array(
            "title" => "jQuery Scroll Pane",
            "description" => "Pretty, customisable, cross browser replacement scrollbars <a target='_blank' href='https://github.com/vitch/jScrollPane'>https://github.com/vitch/jScrollPane</a>",
            "js"=>array(
                "jscrollpane" => array(
                    "file" => "jquery.jscrollpane.min.js",
                    "url" => "https://raw.github.com/vitch/jScrollPane/master/script/jquery.jscrollpane.min.js"
                )
            ),
            "css"=>array( 
                "jscrollpane" => array(
                    "file" => "jquery.jscrollpane.css",
                    "url" => "https://raw.github.com/vitch/jScrollPane/master/style/jquery.jscrollpane.css"
                )),
            "other"=>array()
        ),
        "html5shiv" => array(
            "title" => "HTML5 Shiv",
            "description" => "This script is the defacto way to enable use of HTML5 sectioning elements in legacy Internet Explorer, as well as default HTML5 styling in Internet Explorer 6 - 9, Safari 4.x (and iPhone 3.x), and Firefox 3.x. <a target='_blank' href='https://github.com/aFarkas/html5shiv'>https://github.com/aFarkas/html5shiv</a>",
            "js"=>array(
                "html5shiv" => array(
                    "file" => "html5shiv.js",
                    "url" => "https://raw.github.com/aFarkas/html5shiv/master/src/html5shiv.js"
                )
            ),
            "css"=>array(),
            "other"=>array()
        ),
        
    );
    
    /**
     * @var string  Created options page  
     */
    var $page = '';
    
    /**
    * Class Constructor
    */
    function __construct() {       
        // add the admin options page
        add_action('admin_menu',array($this, 'theme_scripts_settings_page'));
        
        // Add the action to register any javascript required
        add_action('wp_enqueue_scripts',  array($this,'theme_scripts_enqueue_scripts'));
        
        // settings
        add_action('admin_init', array($this, 'scripts_settings_api_init'));
        
        // Move Javascript to the footer
        add_action('init', array($this, 'javascript_to_footer'));	
        
    } // end function
     
    
    /**
    * Move the javascript into the footer
    */
    function javascript_to_footer () {
        if (get_option('javascript_to_footer') == 1) { 
            // Move All Scripts To the Footer
            remove_action('wp_head', 'wp_print_scripts');
            remove_action('wp_head', 'wp_print_head_scripts', 9);
            remove_action('wp_head', 'wp_enqueue_scripts', 1);
            add_action('wp_footer', 'wp_print_scripts', 5);
            add_action('wp_footer', 'wp_enqueue_scripts', 5);
            add_action('wp_footer', 'wp_print_head_scripts', 5);
        } // end if
    } // function
    
    /**
     * Regsiter settings, sections and metaboxes
     */
    function scripts_settings_api_init() {
        // Add the section 
        add_settings_section('manage-scripts',
                'Scripts',
                array(&$this,'empty_callback'),
                $this->page);

         // Add the section 
        add_settings_section('download-scripts',
                'Scripts',
                array(&$this,'empty_callback'),
                $this->page);
        
        // Add a metabox to hold our section
        add_meta_box('manage-scripts',
                'Manage Scripts', 
                array(&$this, 'scripts_metabox'),
                $this->page,
                'normal',
                'core');
        
        add_meta_box('download-scripts',
                'Download Scripts',
                array(&$this, 'download_scripts_metabox'),
                $this->page,
                'normal',
                'core');
        
        // Add the field with the names and function to use for our new
        // settings, put it in our new section
        add_settings_field('javascript_to_footer',
                'Load javascript in the footer?',
                array(&$this,'javascript_to_footer_field'),
                $this->page,
                'scripts');
        
        add_settings_field('scripts_to_load',
                'Always load the following scripts?',
                array(&$this,'load_scripts_via_handle'),
                $this->page,
                'scripts');
 
        add_settings_field('downloaded_scripts_to_load',
                'Always load?',
                array(&$this,'empty_callback'),
                $this->page,
                'scripts');
        
        // Register our setting so that $_POST handling is done for us and
        // our callback function just has to echo the <input>
        register_setting('scripts','javascript_to_footer');
        register_setting('scripts','scripts_to_load');
        register_setting('scripts','downloaded_scripts_to_load');
    }// function
 
    /**
     * An empty section callback
     */
    function empty_callback() { } // end function
    

    /**
     * Print the checkboxes for all the internal scripts
     */
    function load_scripts_via_handle() {
        $scripts_to_load = get_option('scripts_to_load');
        foreach ($this->handles as $script => $description) {
            echo '<label style="width:180px; float:left;" for="scripts_to_load_' . $script . '"><input ' . ( isset($scripts_to_load[ $script]) ? checked( 1,  $scripts_to_load[ $script], false ) : '' ). ' type="checkbox" value="1" id="scripts_to_load_' . $script . '" name="scripts_to_load[' . $script . ']" /> ' . $script. '</label>';
        }
    }

    /**
     * 
     */
    function javascript_to_footer_field() {
            echo '<input name="javascript_to_footer" id="javascript_to_footer" type="checkbox" value="1" class="code" ' . checked( 1, get_option('javascript_to_footer'), false ) . ' /> <em>Yes, load all the javascript in the footer</em>';
    }
    
 
    /**
     * metabox
     */
    function download_scripts_metabox() {
       $downloaded_scripts_to_load = get_option('downloaded_scripts_to_load');
        // output the form fields for each script
        foreach ($this->scripts as $script => $data) {
            // check if it is already installed
            $installed = $this->script_install_check($data);

            print "<div style='margin:15px 0px 25px 0px; padding:0px 10px;'>";
            print "<span style='font-size:12px; width:220px; display:block; float:left; line-height: 25px;'><strong>" . $data['title'] . "</strong>" .  ($installed ? ' <span style="color:green;">(installed)</span>' :' <span style="color:red;">(not installed)</span>')  . "</span> ";

            print '<input name="update-' . $script  . '" id="update-' . $script  . '" type="submit" class="button-secondary" value="' . ($installed  ? 'Update' : 'Install'). '" /> ';

            if ($installed ) {
                print '<input name="delete-' . $script  . '" id="delete-' . $script  . '" type="submit" class="button-secondary" value="Uninstall" /> ';
            
                 echo '<label  for="downloaded_scripts_to_load_' . $script . '"><input ' . ( isset($downloaded_scripts_to_load[ $script]) ? checked( 1,  $downloaded_scripts_to_load[ $script], false ) : '' ). ' type="checkbox" value="1" id="downloaded_scripts_to_load_' . $script . '" name="downloaded_scripts_to_load[' . $script . ']" /> <em>Always load ' . $script. '?</em></label>';
           
            }

            print "<p>" . $data['description'] . "</p>";
            print "</div>";
        } // end foreach
    } // end function
    
    /**
     * 
     */
    function scripts_metabox() {
        echo '<table class="form-table">'; 
            // Output the settings fields asssigned to this section
            do_settings_fields(  $this->page, 'scripts'); 
        echo '</table>';
    } // end function

    /**
    * Register and enqueue the files needed for qTip 
    * @return void
    */
    function theme_scripts_enqueue_scripts() {
        
          $downloaded_scripts_to_load = get_option('downloaded_scripts_to_load');
          
        
        // Register the css and javascript and make them available to other plugins
        foreach ($this->scripts as $script => $fields ) {
           foreach ( $fields['js'] as $name => $data ) {
                wp_register_script($name, plugins_url($data['file'], __FILE__), array('jquery'), '1.0', true);
           }
           foreach ( $fields['css'] as $name => $data ) {
                wp_register_style($name, plugins_url($data['file'], __FILE__), array('jquery'), '1.0', true);
           }  
          
    
            if (isset($downloaded_scripts_to_load[$script]) && ($downloaded_scripts_to_load[$script] == 1)) {
                foreach ( $fields['js'] as $name => $data ) {
                    wp_enqueue_script($name);

                }
                foreach ( $fields['css'] as $name => $data ) {
                    wp_enqueue_style($name);
                } 
            }
        }
        
        
        $scripts_to_load = get_option('scripts_to_load');
        foreach ($this->handles as $script => $description) {
            if (isset($scripts_to_load[$script]) && ($scripts_to_load[$script] == 1)) {
                wp_enqueue_script($script);
            }
        }
    } // end function

    /**
     * Add a settings page
     */
    function theme_scripts_settings_page() {
	$this->page = add_options_page('Scripts', 'Scripts', 'edit_theme_options', 'scripts', array($this,'theme_scripts_settings'));
        add_action('load-'.$this->page,  array(&$this, 'enqueue_settings_page_scripts'));	   
    } // end function
    
    /**
     * Html Output of the settings page
     * @return void
     */
    function theme_scripts_settings() {
        // update any scripts if we pressed the button
        $this->script_update() ;
         
        // Print the form header
        print '<div class="wrap">' .screen_icon('options-general') . '<h2>Install/Manage Scripts</h2>';   
        ?>
        <form id="settings" action="options.php" method="post" enctype="multipart/form-data">
        <div id="poststuff" class="metabox-holder">
            <div id="post-body" >
                <div id="post-body-content" >
                    <?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false ); ?>
                    <?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false ); ?>
                    <?php settings_fields('scripts'); ?>
                    <?php do_meta_boxes($this->page, 'normal', array()); ?>
                    <p><input type="submit" value="Save Changes" class="button-primary" name="Submit"/></p>	
                </div>
            </div>
            <br class="clear"/>				
        </div>
        </form>
        <form id="script-updater" action="" method="post">
            <?php wp_nonce_field( 'script_updater','script_updater_nonce' ); ?>
            <input id="script-updater-input" type="hidden" name="update-nothing" value="update-nothing" />
        </form>
        </div>
        <script type="text/javascript">
            //<![CDATA[
            jQuery(document).ready( function($) {
                    $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
                    postboxes.add_postbox_toggles('<?php echo $this->page; ?>');
                    $('#download-scripts input.button-secondary').click(function(event) {
                        event.preventDefault();
                        $('#script-updater-input').attr('name',$(this).attr('name'));
                        $('#script-updater-input').attr('value',$(this).attr('value'));
                        $('#script-updater').submit();
                    });

            });
            //]]>
        </script>
        <?
    } // end function
    
    /**
    * Runs only on the plugin page load hook, enables the scripts needed for metaboxes
    *
    * @since	0.0.1
    * @access	public
    * @return   void
    */
    function enqueue_settings_page_scripts() {
        wp_enqueue_script('common');
        wp_enqueue_script('wp-lists');
        wp_enqueue_script('postbox');
    } // function

    
    
    /**
     * Check that each of the defined files exist in the plugin directory
     * @param array $files 
     * @return boolean 
     */
    function script_install_check($files) {
        // check all the css files exist
        foreach ($files['css'] as $name => $data ) {
            if (!file_exists(plugin_dir_path(__FILE__) . $data['file'])) {
                return false;
            } // end if
        } // end foreach
        
        // check all the javascript files exist
        foreach ($files['js'] as $name => $data ) {
             if (!file_exists(plugin_dir_path(__FILE__) . $data['file'])) {
                return false;
            } // end if
        } // end foreach
        
        // if we made it here then it must be installed so return true
        return true;
    } // end function
   
    /**
     * Update a script from its remote source
     * @global object $wp_filesystem
     * @return boolean 
     */
    function script_update() {
        // globalize the filesystem object
        global $wp_filesystem;
        
        // if no button was press/nothing was submitted then dont do anything
	if (empty($_POST)) return false;

        // make sure we came from a legit location
        check_admin_referer( 'script_updater','script_updater_nonce');
        
        // Build a list of the form fields we want passed along between page views
        $form_fields = array ();
        foreach ($this->scripts as $script => $files) {
            $form_fields[] = 'update-' . $script;
        } // end foreach
        
        // Normally you leave this an empty string and it figures it out by itself, but you can override the filesystem method here
        $method = ''; 
           
        // get some credentials
        $url = wp_nonce_url('themes.php?page=scripts');
        if (false === ($creds = request_filesystem_credentials($url, $method, false, false, $form_fields) ) ) {

            // if we get here, then we don't have credentials yet,
            // but have just produced a form for the user to fill in, 
            // so stop processing for now

            return true; // stop the normal page form from displaying
        }

        // now we have some credentials, try to get the wp_filesystem running
        if ( ! WP_Filesystem($creds) ) {
            // our credentials were no good, ask the user for them again
            request_filesystem_credentials($url, $method, true, false, $form_fields);
            return true;
        }
        
        // go through the scripts
        foreach ($this->scripts as $script => $files) {
            
            // check to see if we are trying to delete a script
            if (isset($_POST['delete-' . $script])) {
                
                foreach ($files['css'] as $name => $data ) {
                    $wp_filesystem->delete(plugin_dir_path(__FILE__) . $data['file']);
                } // end foreach
                
                foreach ($files['js'] as $name => $data ) {
                    $wp_filesystem->delete(plugin_dir_path(__FILE__) . $data['file']);
                } // end foreach
                
                print '<div class="updated fade"><p>' . $files['title'] . ' has been successfully uninstalled.</p></div>';
                return true;
            }  // end if
 

            // check to see if we are trying to update a script
            if (isset($_POST['update-' . $script])) {
             
                foreach ($files['js'] as $name => $data ) {
                    $response = wp_remote_get($data['url'] , array('timeout' => 120));
                    if (is_wp_error($response)) {
                        echo '<div class="error fade"><p>Error connecting to server: ' . $data['url']  . '</p></div>';
                        return false;
                    }
                    if ( ! $wp_filesystem->put_contents( trailingslashit(plugin_dir_path(__FILE__)). $data['file'] , $response['body'], FS_CHMOD_FILE) ) {
                        echo '<div class="error fade"><p>Error saving file: ' . trailingslashit(plugin_dir_path(__FILE__)). $data['file'] . '</p></div>';
                        return false;
                    }
                } // end foreach
                
                foreach ($files['css'] as $name => $data ) {
                    $response = wp_remote_get($data['url'] , array('timeout' => 120));
                    if (is_wp_error($response)) {
                        echo '<div class="error fade"><p>Error connecting to server: ' . $data['url']  . '</p></div>';
                        return false;
                    } // end if
                    if ( ! $wp_filesystem->put_contents( trailingslashit(plugin_dir_path(__FILE__)). $data['file'] , $response['body'], FS_CHMOD_FILE) ) {
                        echo '<div class="error fade"><p>Error saving file: ' . trailingslashit(plugin_dir_path(__FILE__)). $data['file'] . '</p></div>';
                        return false;
                    } // end if
                } // end foreach
                
                print '<div class="updated fade"><p>' . $files['title'] . ' has been successfully installed.</p></div>';
                      
            } // end if
            
        } // end foreach
        
	return true;
    } // end function
    
    
} // end class

// start
$scripts = new Scripts();




