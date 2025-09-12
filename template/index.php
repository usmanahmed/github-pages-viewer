<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DevDocs &#8211; Easy to find documentation for Usman</title>
    <meta name='robots' content='noindex, nofollow' />
    <link rel="stylesheet" id="style-css" href="<?php echo SITE_URL; ?>/template/assets/style.css" type="text/css" media="all" />
    <script>
        var site_url = "<?php echo SITE_URL; ?>";
        var site_name = "DevDocs";
    </script>

    <link rel="icon" type="image/png" href="<?php echo SITE_URL; ?>/favicon.png">


</head>

<body class="home page-template-default page page-id-5">
    <div id="container">
        <div id="skill">
            <?php echo load_skill($_SERVER['REQUEST_URI']); ?>
            <?php // include 'skill.php'; ?>            
        </div>

    </div>
    <script type='text/javascript' src='<?php echo SITE_URL; ?>/template/assets/jquery.js'></script>
    <!-- <script type='text/javascript' src='<?php echo SITE_URL; ?>/template/assets/main.js'></script> -->
    <script>
        let ajax_link;
        let content_container = $('#content');
        $('#side-list a').on('click', function (e) {
            e.preventDefault();

            ajax_link = $(this).attr('href');

            $.ajax({
                url: ajax_link,
                type: "POST",
                data: {request_type: 'ajax'},
                success: function(response) {
                    content_container.html(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error:", textStatus, errorThrown);
                }
            });
        });
    </script>
</body>

</html>