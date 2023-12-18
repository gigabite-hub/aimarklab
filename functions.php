<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Setup My Child Theme's textdomain.
 *
 * Declare textdomain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
function moniz_child_theme_setup()
{
    load_child_theme_textdomain('moniz-child', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'moniz_child_theme_setup');

if (!function_exists('moniz_child_thm_parent_css')):
    function moniz_child_thm_parent_css()
{
        // loading parent styles
        wp_enqueue_style('moniz-parent-style', get_template_directory_uri() . '/style.css', array('moniz-fonts', 'moniz-icons', 'bootstrap', 'fontawesome'));

        // loading child style based on parent style
        wp_enqueue_style('moniz-style', get_stylesheet_directory_uri() . '/style.css', array('moniz-parent-style'));
    }

endif;
add_action('wp_enqueue_scripts', 'moniz_child_thm_parent_css');

add_action('init', 'add_analytics_endpoint');
function add_analytics_endpoint()
{
    add_rewrite_endpoint('analytics-support', EP_ROOT | EP_PAGES);
}

add_filter('query_vars', 'analytics_query_vars', 0);
function analytics_query_vars($vars)
{
    $vars[] = 'analytics-support';
    return $vars;
}

add_filter('woocommerce_account_menu_items', 'add_new_analytics_tab');
function add_new_analytics_tab($items)
{
    $items['analytics-support'] = 'Analytics';
    return $items;
}

add_action('woocommerce_account_analytics-support_endpoint', 'analytics_tab_content');

function analytics_tab_content()
{
    echo '<h4><strong>Analytics</strong></h4>';

    // HTML structure for three cards
    echo '<div class="analytics-cards-container">
              <div class="analytics-card followers">
                  <p>Followers</p>
                  <h4>34.5K</h4>
                  <p>26.84%</p>
              </div>

              <div class="analytics-card engagement">
                <p>Engagement</p>
                <h4>34.5K</h4>
                <p>26.84%</p>
              </div>

              <div class="analytics-card total-views">
                <p>Total Views</p>
                <h4>34.5K</h4>
                <p>26.84%</p>
              </div>

              <div class="analytics-card total-likes">
                <p>Total Likes</p>
                <h4>34.5K</h4>
                <p>26.84%</p>
              </div>
              <div class="analytics-card profile-discovery">
                <p><strong>Profile Discovery</strong></p>
                <p>26.84% (From last month)</p>
              </div>
          </div>';
}
