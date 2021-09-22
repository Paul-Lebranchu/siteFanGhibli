<?php
set_include_path("./src");
require_once("Rooter.php");
require_once("model/GhilbiStorageMysql.php");
require_once("model/UtilisateurStorageMysql.php");

// /!\ Pensez à adapter cette ligne de code en fonction de l'endroit où vous déplacerez votre
//fichier mysql_config.php. Vous devrez également avoir utiliser le script
// de création de table fourni à coté de cette index dans votre BDD personnel.
require_once('mysql_config.php');


//connexion à la base de données depuis un fichier de config privé
//Fichier qui lance le site
$dsn ='mysql:host='.MYSQL_HOST.';port='.MYSQL_PORT.';dbname='.MYSQL_DB.';charset=utf8';
$user= MYSQL_USER ;
$pass= MYSQL_PASSWORD;
try{
  $bd = new PDO($dsn,$user,$pass);
}catch (PDOException $e) {
  echo 'Connexion échouée : ' . $e->getMessage();
  exit();
}


$root = new Rooter(new GhilbiStorageMySQL($bd),new UtilisateurStorageMySQL($bd));
$root->main();
?>
