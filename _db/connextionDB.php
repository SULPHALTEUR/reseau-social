<?php
  // Déclaration d'une nouvelle classe
  class connexionDB {
    private $host    = 'localhost';  // nom de l'host  
    private $name    = 'data-basse-reseauv2';    // nom de la base de donnée
    private $user    = 'root';       // utilisateur 
    private $pass    = 'root';       // mot de passe (il faudra peut-être mettre '' sous Windows)
    private $connexion;
    
    function __construct($host = null, $name = null, $user = null, $pass = null){
        if($host != null){
            $this->host = $host;           
            $this->name = $name;           
            $this->user = $user;          
            $this->pass = $pass;
        }
        try{
            $this->connexion = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->name,
                $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES UTF8', 
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            }catch (PDOException $e){
                echo 'Erreur : Impossible de se connecter  à la BDD !';
                die();
            }
    }

    public function DB(){
        return $this->connexion;
    }

  }

$DBB = new connexionDB();
$DB = $DBB->DB();
?>  