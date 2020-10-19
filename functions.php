<?php

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * A5T-Framework core
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    *
:::::::::::::     * A5T-Framework includes
                    The $a5t_includes array determines the code library included in your theme.
                    Add or remove files to the array as needed. Supports child theme overrides.
                    Please note that missing files will produce a fatal error.
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

$a5t_includes = array(
    'core/plugins.php',                           // Plugins
    'core/init.php',                              // Initial theme setup and constants
    'core/utils.php',                             // Utilities
    'core/wrapper.php',                           // Theme wrapper class
    'core/config.php',                            // Configuration
    'core/activation.php',                        // Theme activation
    'core/nav.php',                               // Custom nav modifications
    'core/scripts.php',                           // Scripts and stylesheets
    'core/write.php',                             // Writing something on files
    'core/extras.php',                            // Custom functions
    'core/customizer.php',                        // Customize your layout
    'core/security.php',                          // Some security utils
);

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * Setting Comment
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

if (get_theme_mod('a5t_setting_comments')) {
    $a5t_includes[] = 'core/no-comments.php';
}

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * Autoload
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

if (file_exists('vendor/autoload.php')) {
    $a5t_includes[] = 'vendor/autoload.php';
}

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * Aggiorno il CSS nell’area amministratore
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

function admin_style()
{
    wp_enqueue_style('admin-styles', get_template_directory_uri() . '/assets/wp-admin.css');
    /*    wp_enqueue_script( 'admin-script', get_template_directory_uri().'/assets/wp-admin.js', array( 'jquery' ), '1.2.1' );*/
}

// Esegue la funzione admin_style() all’azione admin_enqueue_scripts di WP
add_action('admin_enqueue_scripts', 'admin_style');


/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * Speed test
                    https://wordpress.stackexchange.com/questions/155072/get-option-vs-get-theme-mod-why-is-one-slower
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

/*add_action('wp', 'My_Test');
function My_Test()
{
    var_dump(microtime(true));
    for ($i = 1; $i < 100; $i++) {
        get_option('blogdescription');
    }
    var_dump(microtime(true));
    for ($i = 1; $i < 100; $i++) {
        get_theme_mod('blogdescription');
    }
    var_dump(microtime(true));
    exit;
}*/


/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * Remove Wp Logo
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

function remove_wp_logo($wp_admin_bar)
{
    $wp_admin_bar->remove_node('wp-logo');
}

add_action('admin_bar_menu', 'remove_wp_logo', 100);

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * Customizer admin menu bar
                    https://heera.it/customize-admin-menu-bar-in-wordpress
                    https://webriti.com/customizing-wordpress-admin-bar/
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/


function add_my_own_logo($wp_admin_bar)
{
    $args = array(
        'id' => 'my-logo',
        'meta' => array('class' => 'my-logo', 'title' => 'logo')
    );
    $wp_admin_bar->add_node($args);
}

add_action('admin_bar_menu', 'add_my_own_logo', 1);

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * ?????????
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

foreach ($a5t_includes as $file) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'a5t'), $file), E_USER_ERROR);
    }

    require_once $filepath;
}
unset($file, $filepath);

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * CONTEXT
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
add_filter('timber/context', 'add_to_context');

function add_to_context($context)
{

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    Site
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $context['home'] = site_url();

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    Menu
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $context['menu'] = new Timber\Menu('primary-menu');

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    Theme Dir
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $context['tema_url'] = get_template_directory_uri();
    $context['urltema'] = get_template_directory_uri();

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    Post
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $context['post_class'] = get_post_class()[0];
    $context['post_title'] = get_the_title();

    $context['title'] = get_the_title();
    $context['the_title'] = get_the_title();

    $context['content'] = get_the_content();
    $context['the_content'] = get_the_content();

    $context['imgpage'] = get_the_post_thumbnail_url();
    $context['post_image'] = get_the_post_thumbnail_url();

    $context['intro'] = get_the_excerpt();
    $context['the_excerpt'] = get_the_excerpt();

    $context['urlpage'] = get_page_link();
    $context['page_link'] = get_page_link();

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    Time & Data
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $context['time'] = get_the_time('c');
    $context['date'] = get_the_date();

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    User
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $context['author_url'] = get_author_posts_url(get_the_author_meta('ID'));
    $context['author'] = get_the_author();

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    User WooCommerce Memberships
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

        $context['memberships'] = $memberships = wc_memberships_get_user_active_memberships(get_current_user_id());
    }

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    Footer
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $context['pre_footer'] = Timber::get_widgets('pre_footer');
    $context['footer_col_1'] = Timber::get_widgets('footer_col_1');
    $context['footer_col_2'] = Timber::get_widgets('footer_col_2');
    $context['footer_col_3'] = Timber::get_widgets('footer_col_3');
    $context['footer_col_4'] = Timber::get_widgets('footer_col_4');
    $context['footer_bottom'] = Timber::get_widgets('footer_bottom');

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    Sidebar
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $context['sidebar_primary'] = Timber::get_widgets('sidebar_primary');

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    Slide
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $context['slider'] = get_field('slider');


    $context['main_container'] = get_theme_mod("a5t_setting_main_container");


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    Setting
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $context['setting_intestazione'] = get_theme_mod("a5t_setting_intestazione");
    $context['setting_piva'] = get_theme_mod("a5t_setting_piva");
    $context['setting_indirizzo'] = get_theme_mod("a5t_setting_indirizzo");
    $context['setting_telefono'] = get_theme_mod("a5t_setting_telefono");
    $context['setting_mail'] = get_theme_mod("a5t_setting_mail");


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    If Plugin is active
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    /*if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        echo 'WooCommerce is active.';
    } else {
        echo 'WooCommerce is not Active.';
    }*/


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    WooCommerce
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

        if (WC()->cart->get_cart_contents_count() == 0) {
            $context['carrello'] = '';
        } else {
            $context['carrello'] = '1';
        }

    }


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    Google Maps
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $key = get_theme_mod('a5t_setting_maps');
    $context['googleapis'] = 'http://maps.googleapis.com/maps/api/js?key=' . $key . '&amp;sensor=false';


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    Yoast Breadcrumb
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    if (function_exists('yoast_breadcrumb')) {
        $context['breadcrumbs'] = yoast_breadcrumb('<div id="breadcrumbs" class="breadcrumb center mb-50">', '</div>', false);
    }


    /*
   $custom_logo_id = get_theme_mod( 'custom_logo' );
   $context['logo'] = wp_get_attachment_image_src( $custom_logo_id , 'full' );
   */

// $context['menu_pricipale'] = new Timber\Menu( 'menu-principale' );
// $context['menuu'] = new \Timber\Menu( 'primary-menu' );
// $context['menu'] = new \Timber\Menu( 'primary-menu' );
// $context['menu_servizi'] = new \Timber\Menu( 'Servizi' );
// $context['menu'] = new \Timber\Menu( 'primary-menu' );
// $context['menu_servizi'] = new \Timber\Menu( 'Servizi' );


    return $context;
}

/* toglie icona wp in backend

add_filter( 'timber/context', 'add_to_context' );

if (get_theme_mod('a5t_adv_adminbar')) {
  show_admin_bar(false);
}


*/


/**
 * Wordpress has a known bug with the posts_per_page value and overriding it using
 * query_posts. The result is that although the number of allowed posts_per_page
 * is abided by on the first page, subsequent pages give a 404 error and act as if
 * there are no more custom post type posts to show and thus gives a 404 error.
 *
 * This fix is a nicer alternative to setting the blog pages show at most value in the
 * WP Admin reading options screen to a low value like 1.
 *
 *
 *
 */
function custom_posts_per_page($query)
{

    if ($query->is_archive('batterie')) {
        set_query_var('posts_per_page', 1);
    }
}

add_action('pre_get_posts', 'custom_posts_per_page');


if (!is_admin()) {
    add_action('pre_get_posts', 'set_per_page');
}
function set_per_page($query)
{
    global $wp_the_query;
    if ($query->is_post_type_archive('portfolio') && ($query === $wp_the_query)) {
        $query->set('posts_per_page', 1);
    }
    return $query;
}


/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::::    WOOOCOMMERCE
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/


if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    Conditional function detecting if the current user has an active subscription
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    function has_active_subscription($user_id = null)
    {
        // if the user_id is not set in function argument we get the current user ID
        if (null == $user_id)
            $user_id = get_current_user_id();

        // Get all active subscrptions for a user ID
        $active_subscriptions = get_posts(array(
            'numberposts' => -1,
            'meta_key' => '_customer_user',
            'meta_value' => $user_id,
            'post_type' => 'shop_subscription', // Subscription post type
            'post_status' => 'wcm-active', // Active subscription
        ));
        // if user has an active subscription
        if (!empty($active_subscriptions)) return true;
        else return false;
    }

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    Conditionally checking and adding your subscription when a product is added to cart
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    add_action('woocommerce_add_to_cart', 'add_subscription_to_cart', 10, 6);
    function add_subscription_to_cart($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data)
    {

        // Here define your subscription product
        $subscription_id = '559';
        $found = false;

        if (is_admin() || has_active_subscription() || $product_id == $subscription_id) return;  // exit

        // Checking if subscription is already in cart
        foreach (WC()->cart->get_cart() as $cart_item) {
            if ($cart_item['product_id'] == $subscription_id) {
                $found = true;
                break;
            }
        }
        // if subscription is not found, we add it
        if (!$found)
            WC()->cart->add_to_cart($subscription_id);
    }


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    Add custom checkout field: woocommerce_review_order_before_submit
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    add_action('woocommerce_review_order_before_submit', 'my_custom_checkout_field_condizioni_generali');

    function my_custom_checkout_field_condizioni_generali()
    {
        echo '<div id="my_custom_checkout_field_condizioni_generali" class="col-12">';

        woocommerce_form_field('my_field_name_condizioni_generali', array(
            'type' => 'checkbox',
            'class' => array('input-checkbox'),
            'label' => __('Accetto termi e condizioni generali ( sendsrl.it/tec )'),
            'required' => true,
        ), WC()->checkout->get_value('my_field_name_condizioni_generali'));
        echo '</div> ';
    }

    add_action('woocommerce_review_order_before_submit', 'my_custom_checkout_field_privacy_policy');
    function my_custom_checkout_field_privacy_policy()
    {
        echo '<div id="my_custom_checkout_field_privacy_policy" class="col-12">';

        woocommerce_form_field('my_field_name_privacy_policy', array(
            'type' => 'checkbox',
            'class' => array('input-checkbox'),
            'label' => __('Dichiaro di aver preso visione della Privacy Policy ( sendsrl.it/tec )'),
            'required' => true,
        ), WC()->checkout->get_value('my_field_name_privacy_policy'));
        echo '</div> ';
    }

    add_action('woocommerce_review_order_before_submit', 'my_custom_checkout_field_informazioni_commerciali');
    function my_custom_checkout_field_informazioni_commerciali()
    {
        echo '<div id="my_custom_checkout_field_informazioni_commerciali" class="col-12">';

        woocommerce_form_field('my_field_name_informazioni_commerciali', array(
            'type' => 'checkbox',
            'class' => array('input-checkbox'),
            'label' => __('Acconsento a ricevere informazioni commerciali'),
        ), WC()->checkout->get_value('my_field_name_informazioni_commerciali'));
        echo '</div> ';
    }

    add_action('woocommerce_review_order_before_submit', 'my_custom_checkout_field_dati_terzi');
    function my_custom_checkout_field_dati_terzi()
    {
        echo '<div id="my_custom_checkout_field_dati_terzi" class="col-12">';

        woocommerce_form_field('my_field_name_dati_terzi', array(
            'type' => 'checkbox',
            'class' => array('input-checkbox'),
            'label' => __('Acconsento il trasferiemnto di dati a terzi'),
        ), WC()->checkout->get_value('my_field_name_dati_terzi'));
        echo '</div>';
    }


// Save the custom checkout field in the order meta, when checkbox has been checked
    add_action('woocommerce_checkout_update_order_meta', 'custom_checkout_field_update_order_meta', 10, 1);
    function custom_checkout_field_update_order_meta($order_id)
    {

        // if ( ! empty( $_POST['my_field_name'] ) )
        // update_post_meta( $order_id, 'my_field_name', $_POST['my_field_name'] );
        if (!empty($_POST['my_field_name_condizioni_generali']))
            update_post_meta($order_id, 'my_field_name_condizioni_generali', $_POST['my_field_name_condizioni_generali']);
        if (!empty($_POST['my_field_name_privacy_policy']))
            update_post_meta($order_id, 'my_field_name_privacy_policy', $_POST['my_field_name_privacy_policy']);
        if (!empty($_POST['my_field_name_informazioni_commerciali']))
            update_post_meta($order_id, 'my_field_name_informazioni_commerciali', $_POST['my_field_name_informazioni_commerciali']);
        if (!empty($_POST['my_field_name_dati_terzi']))
            update_post_meta($order_id, 'my_field_name_dati_terzi', $_POST['my_field_name_dati_terzi']);
    }

// Display the custom field result on the order edit page (backend) when checkbox has been checked
    add_action('woocommerce_admin_order_data_after_billing_address', 'display_custom_field_on_order_edit_pages', 10, 1);
    function display_custom_field_on_order_edit_pages($order)
    {
        $my_field_name = get_post_meta($order->get_id(), 'my_field_name', true);
        $my_field_name_condizioni_generali = get_post_meta($order->get_id(), 'my_field_name_condizioni_generali', true);
        $my_field_name_privacy_policy = get_post_meta($order->get_id(), 'my_field_name_privacy_policy', true);
        $my_field_name_informazioni_commerciali = get_post_meta($order->get_id(), 'my_field_name_informazioni_commerciali', true);
        $my_field_name_dati_terzi = get_post_meta($order->get_id(), 'my_field_name_dati_terzi', true);
        if ($my_field_name_condizioni_generali == 1)
            echo '<p><strong>Accetto termi e condizioni generali ( sendsrl.it/tec ): </strong> <span style="color:red;">Abilitiato</span></p><br>';
        if ($my_field_name_privacy_policy == 1)
            echo '<p><strong>Dichiaro di aver preso visione della Privacy Policy ( sendsrl.it/tec ): </strong> <span style="color:red;">Abilitiato</span></p><br>';
        if ($my_field_name_informazioni_commerciali == 1)
            echo '<p><strong>Acconsento a ricevere informazioni commerciali: </strong> <span style="color:red;">Abilitiato</span></p><br>';
        if ($my_field_name_dati_terzi == 1)
            echo '<p><strong>Acconsento il trasferiemnto di dati a terzi: </strong> <span style="color:red;">Abilitiato</span></p><br>';
    }

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    Inseriemnto del Prezzo Totale se disponibile nel Prodotto
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/


    function show_sku_in_cart_items($item_name, $cart_item, $cart_item_key)
    {
        // The WC_Product object
        $product = $cart_item['data'];

        // Get the  SKU
        $prezzo_totale = $product->get_meta('prezzo_totale');
        $prezzo_scontato = $product->get_meta('prezzo_scontato');

        if ($prezzo_scontato) {
            $prezzo_effettivo = $prezzo_scontato;
        } else {
            $prezzo_effettivo = $prezzo_totale;
        }
        // When SKU doesn't exist
        if (empty($prezzo_totale))
            return $item_name;

        // Add SKU before
        if (is_cart()) {
            $item_name = '<b>Acconto </b><br>' . $item_name . '<br><small class="product-prezzo_totale">' . ' ( Totale del viaggio: ' . $prezzo_effettivo . ' €)</small><br>';
        } else {
            $item_name = '<b>Acconto </b><br>' . $item_name . '<br><small class="product-prezzo_totale">' . ' ( Totale del viaggio: ' . $prezzo_effettivo . ' €)</small><br>';
        }

        return $item_name;
    }

    add_filter('woocommerce_cart_item_name', 'show_sku_in_cart_items', 99, 3);

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    Remove image zoom product
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    function remove_image_zoom_support()
    {
        /* remove image zoom hover */
        remove_theme_support('wc-product-gallery-zoom');
        /* remuve image zoom galley*/
        remove_theme_support('wc-product-gallery-lightbox');
    }

    add_action('wp', 'remove_image_zoom_support', 100);

    add_filter('woocommerce_single_product_image_thumbnail_html', 'wc_remove_link_on_thumbnails');

    function wc_remove_link_on_thumbnails($html)
    {
        return strip_tags($html, '<img>');
    }


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    Rename product data tabs
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    add_filter('woocommerce_product_tabs', 'woo_rename_tabs', 98);
    function woo_rename_tabs($tabs)
    {

        $tabs['description']['title'] = __('More Information');        // Rename the description tab
        $tabs['additional_information']['title'] = __('Product Data');    // Rename the additional information tab

        return $tabs;

    }

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::::    Utility function to get the childs array from a parent product category
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/


    function get_the_childs($product_category)
    {
        $taxonomy = 'product_cat';
        $parent = get_term_by('slug', sanitize_title($product_category), $taxonomy);
        return get_term_children($parent->term_id, $taxonomy);
    }


// Changing the add to cart button text
    add_filter('woocommerce_product_single_add_to_cart_text', 'product_cat_single_add_to_cart_button_text', 20, 1);
    function product_cat_single_add_to_cart_button_text($text)
    {
        global $product;
        if (has_term(get_the_childs('Viaggi'), 'product_cat', $product->get_id()))
            $text = __('PRENOTA ORA', 'woocommerce');
        elseif (has_term(get_the_childs('Membership'), 'product_cat', $product->get_id()))
            $text = __('ENTRA NELLA COMMUNITY', 'woocommerce');

        return $text;
    }


}


