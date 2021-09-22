<?php

require_once("model/UtilisateurStorageMysql.php");

class AuthenticationManager{

  public  $dataBase;

  public function __construct($dataBase){
    $this->dataBase = $dataBase;
  }

  public function connectUser($login,$password,$liste){

    $user = new UtilisateurStorageMysql($this->dataBase);
    //vérifie que le mot de passe et l'identifiant sont compatible l'un avec l'autre dans la base de données
    $compte  = $user->checkAuth($login,$password,$liste);

      //si c'est comptabile, compte sera différent de null, on parcourera alors la base de donnée
      //et on récuperera le pseudo de l'utilisateur,l'ensemble de ses informations et son role
      if($compte != null){
        foreach ($liste as $key=>$utilisateur){
          if($utilisateur->__getNom() === $login){
            $_SESSION['id'] = $key;
          }
        }

        $_SESSION['pseudo'] = $compte->__getNom();
        $_SESSION['user'] = $compte;
        $_SESSION['role']= $compte->__getRole();
        return true;
      }
      return false;

    }


}
 ?>
