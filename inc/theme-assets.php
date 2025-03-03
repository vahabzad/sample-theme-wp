<?php
defined('ABSPATH') || exit('No Access !!!');

function tarahan_enqueue_scripts()
{
//    style
    wp_enqueue_style('tarahan-reset', ARK_THEME_URL . 'assets/css/bootstrap.rtl.min.css', array(), '1', 'all');
    wp_enqueue_style('tarahan-bootstrap', ARK_THEME_URL . 'assets/css/bootstrap.rtl.min.css', array(), '5.3', 'all');
    wp_enqueue_style('tarahan-swiper', ARK_THEME_URL . 'assets/css/swiper.css', array(), '11.1.14', 'all');
    wp_enqueue_style('tarahan-style', ARK_THEME_URL . 'assets/css/style.css', array(), '1', 'all');

//    script
    wp_enqueue_script('tarahan-jquery', ARK_THEME_URL . 'assets/js/jquery-3.7.1.min.js', array(), '3.7', false);
    wp_enqueue_script('tarahan-gsap', ARK_THEME_URL . 'assets/js/gsap.min.js', array(), '3.12.5', true);
    wp_enqueue_script('tarahan-ScrollTrigger', ARK_THEME_URL . 'assets/js/ScrollTrigger.min.js', array(), '3.12.5', true);
    wp_enqueue_script('tarahan-bootstrap', ARK_THEME_URL . 'assets/js/bootstrap.bundle.min.js', array('tarahan-jquery'), '5.3', true);
    wp_enqueue_script('tarahan-swiper', ARK_THEME_URL . 'assets/js/swiper.js', array('tarahan-jquery'), '11.1.14', true);
    wp_enqueue_script('tarahan-main', ARK_THEME_URL . 'assets/js/main.js', array('tarahan-jquery'), '1', true);
    wp_localize_script('tarahan-main', 'my_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'tarahan_enqueue_scripts');
