<?php
include_once('include.php');
$title = "Bonjour"
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $title ?></title>
    <?php
        require_once('_head/meta.php');
        require_once('_head/link.php');
        require_once('_head/script.php');
    ?>
</head>
<body>
    <?php require_once('_menu/menu.php');?>

    <h1><?= $title ?></h1>
</body>
<?php require_once('_footer/footer.php');?>
</html>