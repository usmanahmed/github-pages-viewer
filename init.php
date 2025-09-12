<?php
    include APPPATH . 'config.php';
    include APPPATH . '/functions.php';
    include APPPATH . '/libraries/Parsedown.php';
    include APPPATH . '/libraries/Spyc.php';
    
    $md = new Parsedown();

    define( 'TEMPLATE_PATH', APPPATH . 'template/' );
    define( 'DOCSPATH', ABSPATH . 'docs' );
    
    $main_nav = get_nav(scandir(DOCSPATH));
    $sub_nav = get_nav(scanAllDir(DOCSPATH . $_SERVER['REQUEST_URI']));
    $content = get_content($_SERVER['REQUEST_URI']);

    include TEMPLATE_PATH . 'index.php';
