<?php
include_once('include.php');
$title = "Register"
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
<form method="post">
    <label>Pseudo</label>
    <input type="text" name="pseudo" placeholder="Pseudo">
    <label>Email</label>
    <input type="email" name="email" placeholder="Email">
    <label>Password</label>
    <input type="password" name="password" placeholder="Password">
    <label>confirm password</label>
    <input type="password" name="confpassword" placeholder="confirm password">  
</form>
</body>
<?php require_once('_footer/footer.php');?>
</html>