<?php


/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * A_SETTINGS Configurazione variabili GLOBALS
                    // Asseganzione variabili a5t_setting ad array assets_options
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * A_SETTINGS assets_option third parties
                    // Asseganzione variabili a5t_setting ad array assets_options
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

$GLOBALS['assets_options'] = array(

    // Attiva libreria Bootstrap 4.3.1 CSS JS
    'A5T_SETTING_BOOTSTRAP' => get_theme_mod('a5t_setting_bootstrap'),

    // Attiva libreria Fontawesome 5.15.1 fontawesome.com/icons
    'A5T_SETTING_FA' => get_theme_mod('a5t_setting_fa'),

    // Attiva libreria Animate CSS animate.style
    'A5T_SETTING_ANIMATE' => get_theme_mod('a5t_setting_animate'),

    // Attiva libreria Hover CSS ianlunn.github.io/Hover
    'A5T_SETTING_HOVER' => get_theme_mod('a5t_setting_hover'),

    // Attiva libreria Owl Carousel CSS JS owlcarousel2.github.io/OwlCarousel2
    'A5T_SETTING_OWL_CAROUSEL' => get_theme_mod('a5t_setting_owl_carousel'),

    // Attiva libreria NProgress CSS JS https://ricostacruz.com/nprogress/
    'A5T_SETTING_NPROGRESS' => get_theme_mod('a5t_setting_nprogress'),

    // Attiva libreria Magic Mouse CSS JS magicmousejs.web.app
    'A5T_SETTING_MAGIC_MOUSE' => get_theme_mod('a5t_setting_magic_mouse'),

    // Attiva libreria  Butter JS bcjdevelopment.github.io/butter.js
    'A5T_SETTING_BUTTER' => get_theme_mod('a5t_setting_butter'),

    // Attiva libreria Cocoen CSS JS github.com/jotform/before-after.js
    'A5T_SETTING_COCOEN' => get_theme_mod('a5t_setting_cocoen'),

    // Inserisci API key di Google Maps console.cloud.google.com
    'A5T_SETTING_MAPS' => get_theme_mod('a5t_setting_maps'),

    // http://www.giovannifracasso.it/accettazione-cookies-privacy-banner/
    'A5T_SETTING_COOKIES' => get_theme_mod('a5t_setting_cookies'),

);

// Attivo lista percorsi CSS di terze parti in core/scripts.php
$GLOBALS['A5T_SETTING_CSS'] = array(
    // 'example'   => 'https://example.com/my.css',
    // 'example1'   => get_template_directory_uri() . '/assets/owl-carousel/owl.carousel.min.css',

);

// Attivo lista percorsi JS di terze parti in core/scripts.php
$GLOBALS['A5T_SETTING_JS'] = array(// 'jquery-3-2-1' => '//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js',
);