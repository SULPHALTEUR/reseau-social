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

        if(isset($_POST['connexion'])){
            $pseudo = ucfirst(trim($pseudo));
            $password = trim($password);
            
            if(empty($pseudo)){
                $valid = false;
                $err_pseudo = "Ce champ ne peut pas être vide";
            }

            if(empty($password)){
                $valid = false;
                $err_password = "Ce champ ne peut pas être vide";
            }

            if($valide){
                $req = $DB->prepare("SELECT mdp 
                    FROM users
                    WHERE pseudo = ?");

                $req->execute(array($pseudo));

                $req = $req->fetch();

                if(isset($req['mdp'])){
                    if(password_verify($password, $req['mdp'])) {
                        $valid = false;
                        $err_pseudo = "La combinaion du pseudo / mot de pass est incorrecte";
                    }
                    
                }else{
                    $valid = false;
                    $err_pseudo = "La combinaion du pseudo / mot de pass est incorrecte";
                }
            }

            //insertion a notre bdd
            if($valid){
                $req = $DB->prepare("SELECT * 
                    FROM users
                    WHERE pseudo = ?");

                $req->execute(array($pseudo));

                $req_login = $req->fetch();

                if(isset($req_login['id'])){
                    $date_login = date('Y-m-d H:i:s');
                    $req = $DB->prepare("UPDATE users SET date_login = ? WHERE id = ?");
                    $req->execute(array( $date_login, $req_login['id']));

                    $_SESSION['id'] = $req_login['id'];
                    $_SESSION['pseudo'] = $req_login['pseudo'];
                    $_SESSION['email'] = $req_login['email'];
                    $_SESSION['role'] = $req_login['role'];

                    echo 'ok';
                    header('Location: index.php');
                    exit;
                }else{
                    $valid = false;
                    $err_pseudo = "La combinaion du pseudo / mot de pass est incorrecte";
                }

                
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
    <label>Password</label>
    <input type="password" name="password" value="<?php if(isset($password)){echo $password;}?>" placeholder="Password">
    <button type="submit" name="connexion" class="btn btn-primary">Se connecter</button> 
</form>
<?php require_once('_footer/footer.php');?>
</body>
</html>