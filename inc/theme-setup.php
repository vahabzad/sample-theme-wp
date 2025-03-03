<?php
defined('ABSPATH') || exit('No Access !!!');

//if ( function_exists( 'acf_add_options_page' ) ) {
//    acf_add_options_page( array(
//        'page_title' => 'تنظیمات پوسته',
//        'menu_title' => 'تنظیمات پوسته',
//        'menu_slug'  => 'theme-general-settings',
//        'capability' => 'edit_posts',
//        'redirect'   => false
//    ) );
//}

function tarahan_land_setup_theme(){
    // عنوان سایت در تب مرورگر
    add_theme_support('title');
    // لینک فید ها برای بهبود سئو
    add_theme_support('automatic-feed-links');
    // رجیستر کردن منو ها
    register_nav_menus(
        array(
            'main-menu-1' => __( 'جایگاه فهرست هدر سایت' ),
            'footer-menu' => __( 'جایگاه فهرست فوتر سایت' ),
            'mobile-menu' => __('منو موبایل'),
        )
    );
    require_once ARK_THEME_DIR . 'inc/class-wp-bootstrap-navwalker.php';
}

add_action('after_setup_theme','tarahan_land_setup_theme');

if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'file-box', 200, 200, true );
}