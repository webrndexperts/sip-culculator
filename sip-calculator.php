<?php
/**
 * Plugin Name:     Sip Calculator
 * Plugin URI:      rndexperts.com
 * Description:     This plugin can be used to calculate Systematic Investment Plan (SIP). You can place shortcode **[sip-calculator]** anywhere on your templates, pages or posts.
 * Author:          Rnd Experts
 * Author URI:      rndexperts.com
 * Text Domain:     sip-calculator
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Sip_Calculator
 */
$url = plugin_dir_url(__FILE__);
$path = plugin_dir_path(__FILE__);
define('Sip_Calculator_Url', $url);
define('Sip_Calculator_Path', $path);

/**
 * Registers a stylesheet.
 */
function rnd_register_plugin_styles()
{
    wp_register_style('sip-bootstrapcdn', '//maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css');
    wp_register_script('sip-bootstrapcdnjs', '//maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js', array('jquery'), '', false);
    wp_register_script('sip-chartsjs', '//www.gstatic.com/charts/loader.js', array('jquery'), '', false);

}
// Register style sheet.
add_action('wp_enqueue_scripts', 'rnd_register_plugin_styles');

function rnd_loadPluginTextdomain()
{
    load_plugin_textdomain('sip-calculator', false, basename(dirname(__FILE__)) . '/languages/');
}
add_action('init', 'rnd_loadPluginTextdomain');

function rnd_sip_calc_func($atts)
{
    $a = shortcode_atts(array(
        'invested_amount_monthly' => 2000,
        'estimated_return_rate' => 10,
        'years' => 5,
    ), $atts);
    wp_enqueue_style('sip-bootstrapcdn');
    wp_enqueue_script('sip-bootstrapcdnjs');
    wp_enqueue_script('sip-chartsjs');
    ob_start();
    include Sip_Calculator_Path . 'includes/index.php';
    return ob_get_clean();

}
add_shortcode('sip-calculator', 'rnd_sip_calc_func');
