<?php

/*
Plugin Name: Keyboard Scroll
Plugin URI:
Description: Scroll through posts using the J/K keys
Author: Lutz Schr&ouml;er
Version: 1.05
Author URI: http://www.elektroelch.net/
Requires at least: 3.3
Tested up to: 3.7
Tags: navigation, keyboard
Stable tag: trunk
*/

if ( ! class_exists( 'KeyboardScroll' ) ) {
    class KeyboardScroll
    {
        private static $instance = null;

        public static function get_instance()
        {
            if (null == self::$instance)
                self::$instance = new self;
            return self::$instance;
        } //get_instance()

        private function __construct()
        {
            add_action('plugins_loaded', array(&$this, 'init_plugin'));
        } //__construct()


        function init_plugin() {
            add_action('wp_enqueue_scripts', array(&$this, 'load_script'));
            add_action('wp_head', array(&$this, 'localize_script'));
            if (! $this->options = get_option('keyboard-scroll')) {
                $this->init_options();
                $this->options = get_option('keyboard-scroll');
            }
            if ( is_admin() )
                add_action('admin_menu', array(&$this, 'admin_menu'));
                load_plugin_textdomain('jkks', false, dirname(plugin_basename(__FILE__)) . '/lang');
        }

        public function admin_menu()
        {
            $page = add_options_page('Keyboard Scroll', 'Keyboard Scroll', 'manage_options',
                                     'keyboard-scroll', array(&$this, 'settings_page'));
        }

        public function settings_page()
        {
            require_once('settings.php');
        }

        function init_options() {
            require_once 'init-options.php';
        } //init_options()

            public function load_script()
        {
            global $wp_query;
            // $suffix = defined('SCRIPT_DEBUG') ? '' : '.min';
            $suffix = '';
            wp_register_script('keyboard_scroll', plugin_dir_url(__FILE__) . "keyboard-scroll$suffix.js",
                                array('jquery'), true);
            wp_enqueue_script('keyboard_scroll');
            wp_localize_script('keyboard_scroll', 'jkks', $this->get_language_strings());
//            var_dump($wp_query);
        } //load_script()

        function localize_script() {
        }

        private function get_language_strings()
        {
            global $paged, $wp_query;
            $last_page = ($wp_query->max_num_pages == $paged) ? 1:0;
            $prev_page = isset($_POST['jkks_prev_page']) ? 1:0;
            $next_page = isset($_POST['jkks_next_page']) ? 1:0;
            $dynamic_scroll = isset($this->options['dynamic_scroll']) ? 1:0;
            $scroll_acceleration = isset($this->options['scroll_acceleration']) ? 1:0;
            return array(
                'paged' => __($paged, 'jkks'),
                'permalink_structure' => __(get_option('permalink_structure'), 'jkks'),
                'animationspeed' => __($this->options['animationspeed'], 'jkks'),
                'prev_page' => __($prev_page, 'jkks'),
                'next_page' => __($next_page, 'jkks'),
                'css_class' => __($this->options['css_class'], 'jkks'),
                'pagechange' => __($this->options['pagechange'], 'jkks'),
                'last_page' => __($last_page, 'jkks'),
                'dynamic_scroll' => __($dynamic_scroll, 'jkks'),
                'acceleration' => __($scroll_acceleration, 'jkks')
            );
        } //get_language_strings()

    } //class
} //if

KeyboardScroll::get_instance();