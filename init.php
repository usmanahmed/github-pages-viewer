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


    if (isset($_POST['request_type']) && $_POST['request_type'] == 'ajax') {
        echo load_content(REQUEST);
    } else {
        include TEMPLATE_PATH . 'index.php';
    }

