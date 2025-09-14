<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <meta name='robots' content='noindex, nofollow' />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/template/assets/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/template/assets/prism.css" type="text/css" media="all" />
    <script type='text/javascript' src='<?php echo SITE_URL; ?>/template/assets/prism.js'></script>

    <link rel="icon" type="image/png" href="<?php echo SITE_URL; ?>/favicon.png">


</head>

<body>
    <div id="container">
        <div id="skill">
            <aside>
                <div id="branding">
                    <a href="<?php echo SITE_URL; ?>">Dev Docs</a>
                </div>
                <div id="side-list">
                    <?php echo get_nav(scanAllDir(DOCSPATH)); ?>
                </div>
            </aside>
            <div id="content">
                <?php echo $content ?>
            </div>
        </div>

    </div>

    <script>

        // Generate #links for <h2>
        function generate_hash_links() {
            let content_container = document.getElementById('content');
            const h2s = document.querySelectorAll('#content h2');
            let h2_text;
            let links_list = '<div id="jump-links"><ol class="page-toc">';
            
            for (let h2 of h2s) {
                h2_text = h2.innerText;
                h2_text = h2_text.replace(/[^a-zA-Z0-9_]/g, '-');

                h2.setAttribute('id', h2_text);
                
                links_list += '<li><a href="#' + h2_text + '">' + h2.innerText + '</a></li>';
                
                
            }
            links_list += '</ol></div>';

            content_container.innerHTML += links_list;
        }
        generate_hash_links();

        // Ajax on click on sidebar links
        let ajax_links = document.querySelectorAll('#side-list a');
        let page_title = document.getElementsByTagName('title')[0];
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

                    generate_hash_links();

                    // Execute Prism Syntax Highlighter Library
                    Prism.highlightAll(contentDiv);

                    // Update <title>
                    const parser = new DOMParser();
                    html = parser.parseFromString(html, 'text/html');
                    var heading = html.getElementsByTagName('h1')[0];
                    page_title.innerText = heading.innerText;

                })
                .catch(error => {
                    console.error('Error fetching content:', error);
                });
            });
        }
        
    </script>
</body>

</html>