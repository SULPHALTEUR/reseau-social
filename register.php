<?php
    require_once('include.php');
    $title = "Register";

    if(isset($_SESSION['id'])){
        header('Location: index.php');
        exit;
    }

    if(!empty($_POST)){
        extract($_POST);

        $valid = (boolean) true;

        if(isset($_POST['inscription'])){
            $pseudo = ucfirst(trim($pseudo));
            $email = trim($email);
            //conf email nok
            $password = trim($password);
            $confpassword = trim($confpassword);
            
            if(empty($pseudo)){
                $valid = false;
                $err_pseudo = "Ce champ ne peut pas être vide";
            }elseif(grapheme_strlen($pseudo) < 5){
                $valid = false;
                $err_pseudo = "Le pseudo doit faire plus de 5 caractères";
            }elseif(grapheme_strlen($pseudo) >= 25){
                $valid = false;
                $err_pseudo = "Le pseudo doit faire moins de 26 caractères(" . grapheme_strlen($pseudo) . "/25)";
            }else{
                $req = $DB->prepare("SELECT id 
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
                $valid = false;
                $err_email = "Ce champ ne peut pas être vide";
            }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $valid = false;
                $err_email = "Format invalide pour ce mail"; 
            }else{
                $req = $DB->prepare("SELECT id 
                    FROM users
                    WHERE email = ?");

                $req->execute(array($email));

                $req = $req->fetch();

                if(isset($req['id'])){
                    $valid = false;
                    $err_email = "Ce Email est déjà pris";
                }
            }

            if(empty($password)){
                $valid = false;
                $err_password = "Ce champ ne peut pas être vide";
            
            }elseif($password <> $confpassword){
                $valid = false;
                $err_password = "Le mot de passe est different de la confirmation";
            }


            //insertion a notre bdd
            if($valid){
                $crytp_password = password_hash($password, PASSWORD_ARGON2ID);

                echo $crytp_password .'<br>';

                if(password_verify($password, $crytp_password)) {
                    echo 'Le mot de passe est valide!';
                }else{
                    echo 'Le mot de passe est invalide.';
                }
                $date_create = date('Y-m-d H:i:s');
                $req = $DB->prepare("INSERT INTO users(pseudo, email, password, date_create, date_login	) VALUES (?, ?, ?, ?, ?)");
                $req->execute(array($pseudo, $email, $crytp_password, $date_create, $date_create));
                header('Location: login.php');
                exit;

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
    <?php if(isset($err_email)){echo '<div>' . $err_email . '</div>' ;} ?>
    <label>Email</label>
    <input type="email" name="email" value="<?php if(isset($email)){echo $email;}?>" placeholder="Email">
    <?php if(isset($err_password)){echo '<div>' . $err_password . '</div>' ;} ?>
    <label>Password</label>
    <input type="password" name="password" value="<?php if(isset($password)){echo $password;}?>" placeholder="Password">
    <label>confirm password</label>
    <input type="password" name="confpassword" value="" placeholder="confirm password">
    <button type="submit" name="inscription" class="btn btn-primary">Inscription </button> 
</form>
<?php require_once('_footer/footer.php');?>
</body>
</html>