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

function formatNumber($number) {
    if ($number >= 1000) {
        // Format as "4K" for thousands
        return round($number / 1000, 1) . 'K';
    } else {
        // Leave unchanged if less than 1000
        return $number;
    }
}

function calculatePercentage($value, $total) {
    if ($total > 0) {
        return round(($value / $total) * 100, 1) . '%';
    } else {
        return 'N/A'; // Avoid division by zero
    }
}

add_action('woocommerce_account_analytics-support_endpoint', 'analytics_tab_content');

function analytics_tab_content()
{
    echo '<h4><strong>Analytics</strong></h4>';

    // Replace these variables with your actual values
    $page_id = '234502746749024';
    $page_access_token = 'EAAEqipn0O4cBOznj7I7QRO3FXaNZA97q4PrhxMtclyWOm8kG8fZCzyEF7ZB1I2tmu658BNbfhyJksrPD1ZCtLVqS4hMAmjscTuAlqcazMMscAP26BukMoGtaqhrZCTetYFNWitKtmt7lXt1n50AmHdNx8P4YZARmUFzAKOzI6XvQeaWbOsI63h3R70bad04QcZD';

    // Get total followers
    $followersEndpoint = "https://graph.facebook.com/v13.0/{$page_id}?fields=fan_count&access_token={$page_access_token}";
    $followersResponse = json_decode(file_get_contents($followersEndpoint), true);
    $totalFollowers = $followersResponse['fan_count'];

    // Get total page likes
    $pageLikesEndpoint = "https://graph.facebook.com/v13.0/{$page_id}/insights/page_fans?access_token={$page_access_token}";
    $pageLikesResponse = json_decode(file_get_contents($pageLikesEndpoint), true);
    $totalPageLikes = $pageLikesResponse['data'][0]['values'][0]['value'];

    // Get total page views
    $pageViewsEndpoint = "https://graph.facebook.com/v13.0/{$page_id}/insights/page_views_total?access_token={$page_access_token}";
    $pageViewsResponse = json_decode(file_get_contents($pageViewsEndpoint), true);
    $totalPageViews = $pageViewsResponse['data'][0]['values'][0]['value'];

    // Get total page engagement
    $pageEngagementEndpoint = "https://graph.facebook.com/v13.0/{$page_id}/insights/page_engaged_users?access_token={$page_access_token}";
    $pageEngagementResponse = json_decode(file_get_contents($pageEngagementEndpoint), true);
    $totalPageEngagement = $pageEngagementResponse['data'][0]['values'][0]['value'];
		

    // Display the results
    // echo "Total Followers: " . formatNumber($totalFollowers) . PHP_EOL;
    // echo "Total Page Likes: " . formatNumber($totalPageLikes) . PHP_EOL;
    // echo "Total Page Views: " . formatNumber($totalPageViews) . PHP_EOL;
    // echo "Total Page Engagement: " . formatNumber($totalPageEngagement) . PHP_EOL;

    // echo "Total Followers: " . formatNumber($totalFollowers) . ' (' . calculatePercentage($totalFollowers, $totalFollowers) . ')' . PHP_EOL;
    // echo "Total Page Likes: " . formatNumber($totalPageLikes) . ' (' . calculatePercentage($totalPageLikes, $totalFollowers) . ')' . PHP_EOL;
    // echo "Total Page Views: " . formatNumber($totalPageViews) . ' (' . calculatePercentage($totalPageViews, $totalFollowers) . ')' . PHP_EOL;
    // echo "Total Page Engagement: " . formatNumber($totalPageEngagement) . ' (' . calculatePercentage($totalPageEngagement, $totalFollowers) . ')' . PHP_EOL;


    // HTML structure for three cards
    echo '<div class="analytics-cards-container">
        <div class="analytics-card followers">
            <p>Followers</p>
            <h4>'.formatNumber($totalFollowers) . PHP_EOL.'</h4>
            <p>'.calculatePercentage($totalFollowers, $totalFollowers).'</p>
        </div>

        <div class="analytics-card engagement">
        <p>Engagement</p>
        <h4>'.formatNumber($totalPageEngagement) . PHP_EOL.'</h4>
        <p>'.calculatePercentage($totalPageEngagement, $totalFollowers).'</p>
        </div>

        <div class="analytics-card total-views">
        <p>Total Views</p>
        <h4>'.formatNumber($totalPageViews) . PHP_EOL.'</h4>
        <p>'.calculatePercentage($totalPageViews, $totalFollowers).'</p>
        </div>

        <div class="analytics-card total-likes">
        <p>Total Likes</p>
        <h4>'.formatNumber($totalPageLikes) . PHP_EOL.'</h4>
        <p>'.calculatePercentage($totalPageLikes, $totalFollowers).'</p>
        </div>
    </div>';
}
// Add Ingredients Tab
add_action('init', 'add_ingredients_endpoint');
function add_ingredients_endpoint()
{
    add_rewrite_endpoint('ingredients-support', EP_ROOT | EP_PAGES);
}

add_filter('query_vars', 'ingredients_query_vars', 0);
function ingredients_query_vars($vars)
{
    $vars[] = 'ingredients-support';
    return $vars;
}

add_filter('woocommerce_account_menu_items', 'add_new_ingredients_tab');
function add_new_ingredients_tab($items)
{
    $items['ingredients-support'] = 'Ingredients';
    return $items;
}

add_action('woocommerce_account_ingredients-support_endpoint', 'ingredients_tab_content');

function ingredients_tab_content()
{
    echo '<h4><strong>Ingredients</strong></h4>';

    // HTML structure for your content
    echo '<table class="ingredient-table">
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Wholesaler 1 Price</th>
            <th>Wholesaler 2 Price</th>
            <th>Wholesaler 3 Price</th>
            <th>Wholesaler 4 Price</th>
            <th>Best Price Wholesaler</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Onions per lb</td>
            <td>$1.00</td>
            <td>$0.80</td>
            <td>$1.07</td>
            <td>$0.85</td>
            <td>Wholesaler 2</td>
        </tr>
        <tr>
            <td>Raw Pasta per lb</td>
            <td>$2.00</td>
            <td>$2.25</td>
            <td>$1.87</td>
            <td>$1.96</td>
            <td>Wholesaler 3</td>
        </tr>
        <tr>
            <td>Cheese per gram</td>
            <td>$1.15</td>
            <td>$1.04</td>
            <td>$1.08</td>
            <td>$0.99</td>
            <td>Wholesaler 4</td>
        </tr>
        <tr>
            <td>Flour per lb</td>
            <td>$2.25</td>
            <td>$2.49</td>
            <td>$3.25</td>
            <td>$2.75</td>
            <td>Wholesaler 1</td>
        </tr>
    </tbody>
</table>
';
}

