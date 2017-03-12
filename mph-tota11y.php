<?php

/**
 * Plugin Name: MPH tota11y
 * Plugin URI:  https://github.com/matthalliday/mph-tota11y
 * Description: Adds tota11y (Khan Academy's accessibility visualization toolkit) to your website when WP_DEBUG is enabled. Disabling the WordPress toolbar is also strongly recommended.
 * Version:     0.1.0
 * Author:      Matt Halliday
 * Author URI:  http://matthalliday.ca
 * License:     MIT
 */

namespace MPH\tota11y;

class Plugin
{
    private $name = 'mph-tota11y';
    private $version = '0.1.0';
    private static $instance;

    /**
     * Ensures only one instance is loaded or can be loaded.
     * @return MPH_tota11y
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Hook our function onto `wp_enqueue_script` action.
     */
    protected function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScript']);
    }

    /**
     * Determines whether or not debug mode is active.
     * @return boolean
     */
    private function debugModeEnabled()
    {
        return (defined('WP_DEBUG') && WP_DEBUG);
    }

    /**
     * Enqueues script on front end site if debug mode is enabled.
     * @return void
     */
    public static function enqueueScript()
    {
        if ($this->debugModeEnabled()) {
            wp_enqueue_script(
                $this->name,
                plugins_url('tota11y.min.js', __FILE__),
                [],
                $this->version,
                true
            );
        }
    }
}
Plugin::getInstance();
