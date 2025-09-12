<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <div>
        <main>
            <?php echo $md->text( file_get_contents(MDPATH) ); ?>
        </main>
        <aside>
            <?php echo $sub_nav; ?>
        </aside>
    </div>
</body>
</html>