<?php
require __DIR__.'/../autoload.php';
require __DIR__.'/../db.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Giftcard App</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header>
            <h1>Giftcard App</h1>
            <nav>
                <?php include "menu.php"; ?>
            </nav>
        </header>
        <main>
            <?php
            // sanitize page parameter
            $page = basename($_GET['page']);

            // allow only letters and numbers
            $page = preg_replace('/[^a-z0-9_-]/i', '', $page);

            // check if page exists
            if (file_exists(__DIR__.'/../pages/'.$page.'.php')) {
                // include given page securely
                include __DIR__.'/../pages/'.$page.'.php';
            } else {
                // display error message or redirect to a default page
                echo "Invalid page";
            }
            ?>
        </main>
        <footer>
            <p>&copy; <?php echo date("Y"); ?></p>
        </footer>
    </body>
</html>
