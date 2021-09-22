<?php
// /!\ classe non testé /!\
require_once("model/Storage.php");
require_once("model/Utilisateur.php");

class UtilisateurStorageMysql implements Storage{
  private $bd;

  public function __construct($bd){
    $this->bd = $bd;
  }

  //fonction permettant la lecture d'une ligne de la table Utilisateur
  public function read($id){
    $rq = 'SELECT * FROM Utilisateur WHERE id= :id' ;
    $stmt = $this->bd->prepare($rq);
    $data  = array(":id" => $id);
    $stmt->execute($data);
    $res =  $stmt->fetch();
    $data = array( "nom"=>$res['nom'], "mdp"=>$res['mot_de_passe'], "role"=>$res['role'], "mail"=>$res['mail'], "tel"=>$res['tel'], "dateNais"=>$res['date_naissance'], "filmFav"=>$res['film_favori']);
    $utilB = new UtilisateurBuilder($data);
    $util = $utilB->createUtilisateur();
    return $uti;

  }

  //fonction permettant la lecture de toutes les lignes de la table Utilisateur
  function readAll(){
    $rq = 'SELECT * FROM Utilisateur';
    $stmt = $this->bd->prepare($rq);
    $stmt->execute();
    $tab =  $stmt->fetchall();
    $res = array();
    $cpt = 1;

    foreach($tab as $key=>$value){
      $data = array( "nom"=>$value['nom'], "mdp"=>$value['mot_de_passe'], "role"=>$value['role'], "mail"=>$value['mail'], "tel"=>$value['tel'], "dateNais"=>$value['date_naissance'], "filmFav"=>$value['film_favori']);
      $utilB = new UtilisateurBuilder($data);
      $util = $utilB->createUtilisateur();
      $res[$cpt]= $util;
      $cpt+=1;
    }
    return $res;
  }

  //fonction permettant la création d'un nouvel utilisateur
  function create(Utilisateur $object){
    $tab = self::readAll();
    $count = count($tab);
    $rq = 'INSERT INTO Utilisateur(id_utilisateur, nom, mot_de_passe, role, tel, mail, date_naissance, film_favori) VALUES (:id_util,:nom,:mdp,:role,:tel,:mail,:dateNais,:filmF)';
    $stmt = $this->bd->prepare($rq);
    $data  = array(":id_util" => $count+1,":nom" =>$object->__getNom(), ":mdp" => $object->__getMDP(), ":role" =>$object->__getRole(),":tel" =>$object->__getTel(),":mail" =>$object->__getMail(),":dateNais" =>$object->__getDateNaissance(),":filmF" =>$object->__getFilmFav());
    $stmt->execute($data);
    return $object;
  }

  //fonction vérifiant que le nom de compte et le mot de passe mis en paramètre soit compatible
  public function checkAuth($login,$password,$liste){
    foreach($liste as $compte){
      if($compte->__getNom()===$login && password_verify($password,$compte->__getMDP())){
        return $compte;
      }
    }

    return null;
  }
}

 ?>
