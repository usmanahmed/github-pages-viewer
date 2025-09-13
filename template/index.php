<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DevDocs &#8211; Easy to find documentation for Usman</title>
    <meta name='robots' content='noindex, nofollow' />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/template/assets/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/template/assets/prism.css" type="text/css" media="all" />
    <script type='text/javascript' src='<?php echo SITE_URL; ?>/template/assets/prism.js'></script>

    <link rel="icon" type="image/png" href="<?php echo SITE_URL; ?>/favicon.png">


</head>

<body class="home page-template-default page page-id-5">
    <div id="container">
        <div id="skill">
            <?php echo load_skill($_SERVER['REQUEST_URI']); ?>
        </div>

    </div>

    <script>
        let ajax_links = document.querySelectorAll('#side-list a');
        const contentDiv = document.getElementById('content');

        for (let ajax_link of ajax_links) {
            ajax_link.addEventListener('click', function(e) {
                e.preventDefault();
                let url = this.getAttribute('href');
                window.history.pushState("object or string", "Title", url);

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'request_type=ajax'
                })
                .then(response => response.text())
                .then(html => {
                    contentDiv.innerHTML = html;

                    Prism.highlightAll(contentDiv);
                })
                .catch(error => {
                    console.error('Error fetching content:', error);
                });
            });
        }
        
    </script>
</body>

</html>