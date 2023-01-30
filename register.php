<?php
    require_once('include.php');
    $title = "Register";

    if(!empty($_POST)){
        extract($_POST);

        $valid = (boolean) true;

        if(isset($_POST['inscription'])){
            $pseudo = trim($pseudo);
            $email = trim($email);
            $password = trim($password);
            $confpassword = trim($confpassword);

            if(empty($pseudo)){
                $valid = false;
                $err_pseudo = "Ce champ ne peut pas être vide";
                
            }else{
                $req = $DB->prepare("SELECT * 
                FROM users
                WHERE pseudo = ?");

                $req->execute(array($pseudo));

                $req = $req->fetch();

                if(isset($req['id'])){
                    $valid = false;
                    $err_pseudo = "Ce Pseudo est déjà pris";
                }
            }

            if(empty($email)){
                $email = false;
                $err_email = "Ce champ ne peut pas être vide";
            }else{
                $req = $DB->prepare("SELECT * 
                FROM users
                WHERE email = ?");

                $req->execute(array($email));

                $req = $req->fetch();

                if(isset($req['id'])){
                    $valid = false;
                    $err_email = "Ce Email est déjà pris";
                }
            }

            //insertion a notre bdd
            if($valid){
                echo 'ok';
            }else{
                echo 'nok';
            }

        }
    }
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
<?php if(isset($err_pseudo)){echo '<div>' . $err_pseudo . '</div>' ;} ?>
    <label>Pseudo</label>
    <input type="text" name="pseudo" value="<?php if(isset($pseudo)){echo $pseudo;}?>" placeholder="Pseudo">
    <label>Email</label>
    <input type="email" name="email" value="<?php if(isset($email)){echo $email;}?>" placeholder="Email">
    <label>Password</label>
    <input type="password" name="password" value="<?php if(isset($password)){echo $password;}?>" placeholder="Password">
    <label>confirm password</label>
    <input type="password" name="confpassword" value="" placeholder="confirm password">
    <button type="submit" name="inscription" class="btn btn-primary">Inscription </button> 
</form>
</body>
<?php require_once('_footer/footer.php');?>
</html>