<?php

// remove query string from static resources
function _remove_script_version( $src ){ 
$parts = explode( '?', $src );  
return $parts[0]; 
} 
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 ); 
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

// add prefetching rules
function ism_dns_prefetch() {
  echo '<meta http-equiv="x-dns-prefetch-control" content="on">
  <link rel="dns-prefetch" href="//code.jquery.com" />
  <link rel="dns-prefetch" href="//fonts.gstatic.com" />
  <link rel="dns-prefetch" href="//use.fontawesome.com" />
  <link rel="dns-prefetch" href="//www.googletagmanager.com" />
  ';
}
add_action('wp_head', 'ism_dns_prefetch', 0);

// Imposto gli script che mi interessano come async & defer
// in particolare google mappe.
function make_script_async( $tag, $handle, $src )
{
    if ( 'googlemaps' != $handle ) {
        return $tag;
    }

    return str_replace( '<script', '<script async defer', $tag );
}
add_filter( 'script_loader_tag', 'make_script_async', 10, 3 );


  /**
  * CARICO I CSS E I JS
  */
  function a5t_scripts() {
      
    // Carico la lista di CSS     
    foreach ($GLOBALS['CSS'] as $nome => $percorso) {
        wp_enqueue_style(  $nome, $percorso );
    }

    // jQuery is loaded using the same method from HTML5 Boilerplate:
    // Grab Google CDN's latest jQuery with a protocol relative URL; fallback to CDNJS if offline
    // It's kept in the header instead of footer to avoid conflicts with plugins.
    // Support added in init.php
    if (!is_admin() && current_theme_supports('jquery-cdn')) {
      wp_deregister_script('jquery');
      wp_register_script('jquery', 'https://code.jquery.com/jquery-1.11.3.min.js', array(), null, false);
      add_filter('script_loader_src', 'a5t_jquery_local_fallback', 10, 2);
    }
    wp_enqueue_script('jquery');

    // Javascript for comments
    if (is_single() && comments_open() && get_option('thread_comments')) {
      wp_enqueue_script('comment-reply');
    }

    // Loading custom js   
    foreach ($GLOBALS['JS'] as $nome => $percorso) {
        wp_enqueue_script(  $nome, $percorso );
    }

    // Attiva in base alla scalta animate.css
    if ($GLOBALS['assets_options']['ANIMATECSS']) {
      wp_enqueue_style(  'animate', get_template_directory_uri() . '/assets/animate.css' );
    }

    // Attiva in base alla scalta hover.css
    if ($GLOBALS['assets_options']['HOVERCSS']) {
      wp_enqueue_style(  'hover', get_template_directory_uri() . '/assets/hover.css' );
    }

    // Attiva in base alla scalta fontawesome.js
    if ($GLOBALS['assets_options']['FONTAWESOME']) {
        wp_enqueue_script( 'fa', 'https://use.fontawesome.com/releases/v5.0.6/js/all.js', array(), '5.0.6', true );
    }

    // Carico Bootstrap js css
    if (get_theme_mod('a5t_setting_bootstrap')) {
    wp_enqueue_style( 'bootstrap', get_template_directory_uri(). '/assets/bootstrap-4.3.1-dist/css/bootstrap.min.css' );
    wp_enqueue_script( 'bootstrap-js', get_template_directory_uri(). '/assets/bootstrap-4.3.1-dist/js/bootstrap.min.js', array(), '4.3.1', true );
    }


    /* TODO imserire regole per butter_js  */
      wp_enqueue_style( 'butter-js', get_template_directory_uri(). '/assets/butter-js/butter.js' );


      /* TODO inserire regole ipotetica a5t_setting_magicmouse */



      wp_enqueue_style( 'magic-mouse', get_template_directory_uri(). '/assets/magic-mouse-js/magic-mouse.css' );
      wp_enqueue_script( 'magic-mouse', get_template_directory_uri(). '/assets/magic-mouse-js/magic_mouse.js');

      /* TODO inserire regole ipotetica a5t_setting_noprogress */
      wp_enqueue_style( 'nprogress', get_template_directory_uri(). '/assets/nprogress/nprogress.css' );
      wp_enqueue_script( 'nprogress-js', get_template_directory_uri(). '/assets/nprogress/nprogress.js');
      // Carico Bootstrap js css
      if (get_theme_mod('a5t_setting_nprogress')) {
          wp_enqueue_style( 'nprogress', get_template_directory_uri(). '/assets/nprogress/nprogress.css' );
          wp_enqueue_script( 'nprogress-js', get_template_directory_uri(). '/assets/nprogress/nprogress.js');
      }



    // Attiva in base alla scalta cookiechoices.js
    if ($GLOBALS['assets_options']['COOKIES']) {
        wp_enqueue_script( 'cookies', get_template_directory_uri() . '/assets/cookiechoices.js', array(), '1.0.0', true );
    }

    // Carico il JS custom
    wp_enqueue_script( 'scripts', get_template_directory_uri() . '/assets/custom.js', array(), '1.0.0', true );
    wp_enqueue_script( 'credits', get_template_directory_uri() . '/assets/credits.js', array(), '1.0.0', true );

    // Carico il CSS custom
    wp_enqueue_style(  'default', get_template_directory_uri() . '/assets/custom.css' );

  }
add_action( 'wp_enqueue_scripts', 'a5t_scripts', 100 );


// http://wordpress.stackexchange.com/a/12450
// Gestisco un sostituto per JQuery nel caso in cui il primo sia offline
function a5t_jquery_local_fallback($src, $handle = null) {
  static $add_jquery_fallback = false;

  if ($add_jquery_fallback) {
    echo '<script>window.jQuery || document.write(\'<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"><\/script>\')</script>' . "\n";
    $add_jquery_fallback = false;
  }

  if ($handle === 'jquery') {
    $add_jquery_fallback = true;
  }

  return $src;
}
add_action('wp_head', 'a5t_jquery_local_fallback');


/**
 * Cookies directive script
 */

function a5t_cookies() { ?>
    <script>
        document.addEventListener('DOMContentLoaded', function(event) {
        cookieChoices.showCookieConsentBar('<?php echo get_theme_mod("a5t_setting_pri_msg"); ?>', '<?php echo get_theme_mod("a5t_setting_pri_close"); ?>', '<?php echo get_theme_mod("a5t_setting_pri_title"); ?>', '<?php echo get_post_permalink(get_theme_mod("a5t_setting_pri_url")); ?>');
        });
    </script>
<?php }


if ($GLOBALS['assets_options']['COOKIES']) {
    add_action('wp_footer', 'a5t_cookies', 20);
}





/**
 * Analytics script
 */
if ( get_theme_mod('a5t_setting_analytics') != '') {
function a5t_google_analytics() { ?>
    <!-- Google Analytics -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', '<?php echo get_theme_mod('a5t_setting_analytics'); ?>', 'auto');
        ga('send', 'pageview');
    </script>
    <!-- End Google Analytics -->
    <!-- Global Site Tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo get_theme_mod('a5t_setting_analytics'); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '<?php echo get_theme_mod('a5t_setting_analytics'); ?>');
    </script>
<?php }
add_action('wp_head', 'a5t_google_analytics', 20);
}


if (get_theme_mod('a5t_setting_gtag') != '')  {



    function a5t_gtag_head_analytics() { ?>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','<?php echo get_theme_mod('a5t_setting_gtag'); ?>');
        </script>
        <!-- End Google Tag Manager -->
    <?php
    }
    add_action('wp_head', 'a5t_gtag_head_analytics', 20);



    function a5t_gtag_body_analytics() { ?>
        <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo get_theme_mod('a5t_setting_gtag'); ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->
        <?php
    }
    add_action('after_body', 'a5t_gtag_body_analytics', 20);
}



if (get_theme_mod('a5t_setting_hotjar') != '' ) {
function a5t_hotjar_analytics() { ?>
    <!-- Hotjar Tracking Code -->
    <script>

        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:<?php echo get_theme_mod('a5t_setting_hotjar'); ?>,hjsv:5};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
<?php }
    add_action('wp_footer', 'a5t_hotjar_analytics', 20);
}

?>