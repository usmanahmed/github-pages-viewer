<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dev Docs</title>
    <meta name='robots' content='noindex, nofollow' />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/template/assets/style.css" type="text/css" media="all" />

    <link rel="icon" type="image/png" href="<?php echo SITE_URL; ?>/favicon.png">


</head>

<body class="home">
    <div id="container">
        <div id="skill">
            <div id="content">
                <?php echo get_nav(scandir(DOCSPATH)); ?>
            </div>
        </div>

    </div>

</body>

</html>