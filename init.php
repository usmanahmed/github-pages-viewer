<?php
    include APPPATH . 'config.php';
    include APPPATH . '/functions.php';
    include APPPATH . '/libraries/Parsedown.php';
    include APPPATH . '/libraries/Spyc.php';
    
    $md = new Parsedown();

    define( 'TEMPLATE_PATH', APPPATH . 'template/' );
    define( 'DOCSPATH', ABSPATH . 'docs' );
    define( 'URI', str_replace('+', ' ', $_SERVER['REQUEST_URI']) );
    define ( 'MDPATH', DOCSPATH . URI . '/index.md' );

    $pages = scanAllDir(DOCSPATH);

    $sub_nav = get_nav($pages);

    include TEMPLATE_PATH . 'index.php';
