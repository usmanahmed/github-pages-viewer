<?php
    include APPPATH . 'config.php';
    include APPPATH . '/functions.php';
    include APPPATH . '/libraries/Parsedown.php';
    include APPPATH . '/libraries/Spyc.php';
    
    $md = new Parsedown();

    define( 'REQUEST', $_SERVER['REQUEST_URI'] );
    define( 'TEMPLATE_PATH', APPPATH . 'template/' );
    define( 'DOCSPATH', ABSPATH . 'docs' );

    // $main_nav = get_nav(scandir(DOCSPATH));
    // $sub_nav = get_nav(scanAllDir(DOCSPATH . $_SERVER['REQUEST_URI']));
    /* $skill = load_skill($_SERVER['REQUEST_URI']);
    $content = load_content($_SERVER['REQUEST_URI']); */

    // $request_type = explode('/', ltrim(REQUEST, '/') );
    // $request_type = $request_type[0];

    if (isset($_POST['request_type']) && $_POST['request_type'] == 'ajax') {
        echo load_content(REQUEST);
    } else {
        include TEMPLATE_PATH . 'index.php';
    }

