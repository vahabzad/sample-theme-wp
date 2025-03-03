<?php
defined('ABSPATH') || exit('No Access !!!');

define('ARK_THEME_DIR', get_theme_file_path() . '/');
define('ARK_THEME_URL', get_theme_file_uri() . '/');

require_once ARK_THEME_DIR . 'inc/theme-assets.php';
require_once ARK_THEME_DIR . 'inc/theme-setup.php';

function excerpt($length)
{
    return 30;
}

function more($more)
{
    return '...';
}

add_filter('excerpt_more', 'more');
add_filter('excerpt_length', 'excerpt');
add_filter('show_admin_bar', '__return_false');

// بستن تمام دسترسی‌ها به REST API
function disable_rest_api_completely( $access ) {
    return new WP_Error( 'rest_forbidden', 'REST API is disabled', array( 'status' => 403 ) );
}
add_filter( 'rest_authentication_errors', 'disable_rest_api_completely' );
// جلوگیری از نمایش لیست کاربران از طریق URL
function block_author_user_enumeration() {
    if ( isset( $_GET['author'] ) ) {
        wp_redirect( home_url() );
        exit;
    }
}
add_action( 'template_redirect', 'block_author_user_enumeration' );
// غیرفعال کردن XML-RPC
add_filter( 'xmlrpc_enabled', '__return_false' );
function disable_dashboard()
{
    if (is_admin() && !defined('DOING_AJAX') && (current_user_can('subscriber') || current_user_can('contributor'))) {
        wp_redirect(home_url());
        exit;
    }
}
add_action('init', 'disable_dashboard');

function tjnz_head_cleanup() {
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', '', '', '', true);
    }
}
add_action('init', 'tjnz_head_cleanup');

add_filter('gform_confirmation_anchor', '__return_true');
add_filter('gform_validation_message', 'change_message', 10, 2);
function change_message($message, $form)
{
    return '<h2 class="gform_submission_error hide_summary">لطفا خطا ها را برطرف کنید</h2>';
}

//ajax
add_action('wp_ajax_load_more_post', 'load_more_post');
add_action('wp_ajax_nopriv_load_more_post', 'load_more_post');
function load_more_post()
{
    $page = isset($_POST['page']) ? absint($_POST['page']) : 1;
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 6,
        'paged' => $page
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) :
            $query->the_post();
            $post_id = get_the_ID();
            $title = get_the_title();
            ?>
            
        <?php
        endwhile;
    endif;
    wp_reset_postdata();
    die();
}

function search_projects_ajax()
{
    if (isset($_POST['query'])) {
        $search_query = sanitize_text_field($_POST['query']);
        $args = array(
            'post_type' => 'post',
            's' => $search_query,
            'posts_per_page' => 4,
        );
        $search_results = new WP_Query($args);
        $total_posts = $search_results->found_posts;
        if ($search_results->have_posts()) :
            while ($search_results->have_posts()) :
                $search_results->the_post();
                $post_id = get_the_ID();
                $title = get_the_title();
                $post_tags = get_the_tags();
                $post_link = get_permalink();
            endwhile;
        endif;
        wp_reset_postdata();
    }

    wp_die();
}
add_action('wp_ajax_search_projects', 'search_projects_ajax');
add_action('wp_ajax_nopriv_search_projects', 'search_projects_ajax');
//date
function shamsi_to_miladi($date)
{
    $IntlDateFormatter = new IntlDateFormatter(
        'en_US@calendar=persian',
        IntlDateFormatter::NONE,
        IntlDateFormatter::NONE,
        NULL,
        IntlDateFormatter::TRADITIONAL,
        "yyyy/MM/dd"
    );
    $shamsiTimestamp = $IntlDateFormatter->parse($date);
    if ($shamsiTimestamp === false) {
        return false;
    }
    $IntlDateFormatter->setCalendar(IntlDateFormatter::GREGORIAN);
    $IntlDateFormatter->setPattern("yyyy-MM-dd");
    return $IntlDateFormatter->format($shamsiTimestamp);
}
function gregorianToJalali($gy, $gm, $gd) {
    $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

    $gy = (int)$gy - 1600;
    $gm = (int)$gm - 1;
    $gd = (int)$gd - 1;

    $g_day_no = 365 * $gy + floor(($gy + 3) / 4) - floor(($gy + 99) / 100) + floor(($gy + 399) / 400);

    for ($i = 0; $i < $gm; ++$i) {
        $g_day_no += $g_days_in_month[$i];
    }

    if ($gm > 1 && (($gy % 4 == 0 && $gy % 100 != 0) || ($gy % 400 == 0))) {
        $g_day_no++;
    }

    $g_day_no += $gd;
    $j_day_no = $g_day_no - 79;
    $j_np = floor($j_day_no / 12053);
    $j_day_no %= 12053;
    $jy = 979 + 33 * $j_np + 4 * floor($j_day_no / 1461);
    $j_day_no %= 1461;

    if ($j_day_no >= 366) {
        $jy += floor(($j_day_no - 1) / 365);
        $j_day_no = ($j_day_no - 1) % 365;
    }

    for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i) {
        $j_day_no -= $j_days_in_month[$i];
    }

    $jm = $i + 1;
    $jd = $j_day_no + 1;

    return array($jy, $jm, $jd);
}
function convertDateToJalali($date) {
    list($year, $month, $day) = explode('-', $date);
    list($jYear, $jMonth, $jDay) = gregorianToJalali($year, $month, $day);
    return  $jYear . '/' . $jMonth . '/' . $jDay;
}
