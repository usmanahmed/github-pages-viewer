<?php
    include APPPATH . 'config.php';
    include APPPATH . '/functions.php';
    include APPPATH . '/libraries/Parsedown.php';
    include APPPATH . '/libraries/Spyc.php';
    
    $md = new Parsedown();

    define( 'REQUEST', $_SERVER['REQUEST_URI'] );
    define( 'TEMPLATE_PATH', APPPATH . 'template/' );
    define( 'DOCSPATH', ABSPATH . 'docs' );

    file_put_contents(DOCSPATH . '/index.md', generate_nav(scanAllDir(DOCSPATH)));

    $content = load_content(REQUEST);
    // load title
    $title = strip_tags( explode('</h1>', $content)[0] );


    if (isset($_POST['request_type']) && $_POST['request_type'] == 'ajax') {
        echo $content;
        exit;
    } elseif(REQUEST == '/') {
        include TEMPLATE_PATH . 'home.php';
    } else {
        include TEMPLATE_PATH . 'index.php';
    }

