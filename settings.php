<?php

class KeyyboardScrollOptions {

    private static $instance = null;
// ---------------------------------------------------------------------------------------------------------------------
    public static function get_instance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    } //get_instance()
// ---------------------------------------------------------------------------------------------------------------------
    function __construct() {
        if ( ! current_user_can('manage_options') )  {
            wp_die( __('You do not have sufficient permissions to access this page.', 'jkks') );
        }
        $this->form();
    } //_construct
    // -----------------------------------------------------------------------------------------------------------------
    function save_options() {
        $options = array();

        $options['animationspeed'] = isset($_POST['animationspeed']) ? intval($_POST['animationspeed']) : 0;
        $options['css_class'] = isset($_POST['css_class']) ? $_POST['css_class'] : 'post';
        $options['pagechange'] = isset($_POST['pagechange']) ? 1 : 0;
        $options['dynamic_scroll'] = isset($_POST['dynamic_scroll']) ? 1 : 0;
        $options['scroll_acceleration'] = isset($_POST['scroll_acceleration']) ? floatval($_POST['scroll_acceleration']) : 0;

        update_option('keyboard-scroll', $options);
    }
    // -----------------------------------------------------------------------------------------------------------------
    function get_option($name) {
        if (isset($this->options[$name]))
            return $this->options[$name];
    }
    // -----------------------------------------------------------------------------------------------------------------
    function init_options() {
        require_once 'init-options.php';
    } //init_options()

    // -----------------------------------------------------------------------------------------------------------------
    function form (){

        if (isset($_POST['jkks-form'])) {
            $this->save_options();
            echo '<div id="message" class="updated fade"><p><strong>' . __('Settings saved.', 'jkks') . '</strong>   </p></div>';
        }
        if (! $this->options = get_option('keyboard-scroll')) {
            $this->init_options();
            $this->options = get_option('keyboard-scroll');
        }
        wp_nonce_field( 'jkks_update' ); ?>

        <div class="wrap">
        <div id="jkks-icon" style="background: url(<?php echo plugin_dir_url(__FILE__); ?>icon_32x32.png) no-repeat;" class="icon32"></div>
        <h2>Keyboard Scroll</h2>
        <form method="post" action="<?php echo $_SERVER ['REQUEST_URI']; ?>">
        <input type="hidden" name="jkks-form" value="1" />

        <table class="form-table">

        <tr valign="top">
            <th scope="row"><?php _e('Animation speed', 'jkks'); ?></th>
            <td>
                <input type="text" name="animationspeed" value="<?php echo $this->get_option('animationspeed') ?>" />
                <br/><small><em><?php _e('(Default: 200; 0 = no animation)', 'jkks') ?></em></small>
            </td>
        </tr>

        <th scope="row"><?php _e('CSS class', 'jkks'); ?></th>
        <td>
            <input type="text" name="css_class" value="<?php echo $this->get_option('css_class') ?>" />
            <br/><small><em><?php _e('(Default: post)', 'jkks') ?></em></small>
        </td>
        </tr>

        <th scope="row"><?php _e('Page change', 'jkks'); ?></th>
        <td>
            <label for="pagechange"><input type="checkbox" name="pagechange" id="pagechange"
                <?php echo($this->get_option('pagechange')?'checked="checked"':""); ?> />
                <?php _e('Change to next or previous page if bottom or top of page is reached.', 'jkks'); ?></label>
        </td>
        </tr>

        <th scope="row"><?php _e('Dynamic scrolling', 'jkks'); ?></th>
        <td>
            <label for="dynamic_scroll"><input type="checkbox" name="dynamic_scroll" id="dynamic_scroll"
                    <?php echo($this->get_option('dynamic_scroll')?'checked="checked"':""); ?> />
                <?php _e('Speed up scrolling if user presses keys rapidly.', 'jkks'); ?></label>
        </td>
        </tr>

        <th scope="row"><?php _e('Acceleration', 'jkks'); ?></th>
        <td>
            <input type="text" name="scroll_acceleration" value="<?php echo $this->get_option('scroll_acceleration') ?>" />
            <br/><small><em><?php _e('(Scroll acceleration factor)', 'jkks') ?></em></small>
        </td>
        </tr>



        </table>

        <?php submit_button(); ?>

        </form>
        </div>

    <?php

    } //form()

// ---------------------------------------------------------------------------------------------------------------------
} //class

KeyyboardScrollOptions::get_instance();