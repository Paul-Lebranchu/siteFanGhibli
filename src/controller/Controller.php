<?php
require_once("view/View.php");
require_once("model/GhilbiStorageMysql.php");
require_once("model/UtilisateurStorageMysql.php");
require_once("model/UtilisateurBuilder.php");
require_once("AuthenticationManager.php");

class Controller{

  protected $view;
  protected $listeP;
  protected $user;

  public function __construct(View $view, GhilbiStorageMysql $listeP, UtilisateurStorageMysql $user){
    $this->view = $view;
    $this->listeP = $listeP;
    $this->user = $user;
  }

  public function aProposPage(){
    $this->view->makeAProposPage();
  }

  public function accueilPage(){
    $this->view->makeAccueilPage();
  }

  public function creationCompte(){
    $this->view->makeCreationComptePage();
  }

  public function creationObject(){
  	$this->view->ajoutObjetListe($this->newGhibliObject());
  }

   public function modifObjet($data){
    $this->view->ModifObjet($this->modifGhibliObject());

  }

  public function showList(){
    $this->view->makeListPage($this->listeP->readAll());
  }

  //on affiche l'objet si il existe, sinon on affiche une page d'erreur
  public function detailObjet($id){
    if(key_exists("$id",$this->listeP->readAll())){
      $this->view->makeDetailPage($this->listeP->read($id), $this->listeP->readAll());
    }
    else{
      $this->view->unknowObject();
    }
  }

  public function connexionPage(){
    $this->view->makeLoginFormPage();
  }

  public function supprimer($id){
	  $this->view->makeSupprimerPage($id);
  }

  public function defSupprimer($id){
    $this->listeP->delete($id);
		$this->view->makeDefSupprimerPage();
  }

  //fonction s'occuppant de la création des comptes
  public function sauvegardeCompte($data){

    $compte  = new UtilisateurBuilder($data);

    if($compte->isValid()){
      $util = $compte->createUtilisateur();
      $this->user->create($util);//ajoute le nouvel utilisateur à la base de donnée
      $this->view->displayUtilisateurSuccess();//affiche le succès de la création de l'utilisateur
      unset($_SESSION['currentNewCompte']);

    }else{
      $_SESSION['currentNewCompte']= $compte;
      $this->view->displayUserCreationFailed();
    }
  }

  //gestion des données dans le formulaire de création de comptes
  public function newCompte(){

    if(key_exists('currentNewCompte',$_SESSION)){
      $compte = $_SESSION['currentNewCompte'];
    }
    else{
      $compte = new UtilisateurBuilder($_POST);
    }
    return $compte;
  }

    public function newGhibliObject(){

    if(key_exists('currentNewGhibliObject',$_SESSION)){
      $ghibliObject = $_SESSION['currentNewGhibliObject'];
    }else{
      $ghibliObject = new GhilbiBuilder($_POST);
    }
    return $ghibliObject;
  }

  public function modifGhibliObject(){

    if(key_exists('currentModifGhibliObject',$_SESSION)){
      $ghibliObject = $_SESSION['currentModifGhibliObject'];
    }else{
      $ghibliObject = new GhilbiBuilder($_POST);
    }
    return $ghibliObject;
  }

  public function sauvegardeObjet($data){

    $ghibliObject = new GhilbiBuilder($data);

    if($ghibliObject->isValid()){
      $util = $ghibliObject->createGhibli();
      $this->listeP->create($util);//ajoute le nouvel objet à la base de donnée
      $this->view->displayObjectSuccess();//affiche le succès de la création de l'objet
      unset($_SESSION['currentNewGhibliObject']);

    }else{
      $_SESSION['currentNewGhibliObject']= $ghibliObject;
      $this->view->displayObjectCreationFailed();
    }
  }
  public function updateObjet($data){

    $ghibliObject = new GhilbiBuilder($data);

    if($ghibliObject->isValid()){
      $util = $ghibliObject->createGhibli();
      $this->listeP->modif($util);//modifie l'objet
      $this->view->displayObjectModificationSuccess($data["id_objet"]);//affiche le succès de la modification de l'objet
      unset($_SESSION['currentModifGhibliObject']);

    }else{
      $_SESSION['currentModifGhibliObject']= $ghibliObject;
      $this->view->displayObjectModificationFailed();
    }
  }

  public function recherche(){
    $listeRech=[];
    $listeComplete=$this->listeP->readAll();
    if ($_POST["recherche"] == "" && $_POST["num"] == ""){
      $this->view->makeListPage($listeComplete);
    }
    else{
      foreach ($listeComplete as $object){
        //stristr($object->__getNomProduit(), $_POST) === 
        //echo($object->__getNomProduit());
        if($_POST["recherche"] != "" && stristr($object->__getNomProduit(), $_POST["recherche"]) != False){
          if($_POST["num"] == "" || ($_POST["num"] != "" && $object->__getIdCreateur() == (int)$_POST["num"])){
            $listeRech[] = $object;
          }
        }elseif($_POST["recherche"] == "" && $object->__getIdCreateur() == (int)$_POST["num"]){
          $listeRech[] = $object;
        }
      }
      $this->view->makeListPage($listeRech);
    }
  }

  //gestion de la connexion
  public function connect($liste,$data){

    //utilisateur non connecté -> verifie le login/mot de passe et connecte ou refuse la connexion
    if(!key_exists("user",$_SESSION)){
      $authentification = new AuthenticationManager($this->user);

      if(key_exists('login',$_POST)){
        $login = $_POST['login'];
      }else{
        $login = null;
      }

      if(key_exists('password',$_POST)){
        $password = $_POST['password'];
      }else{
        $password = null;
      }

      if($authentification->connectUser($login,$password,$liste)){
        $this->view->displayConnectionSuccess();
      }
      else{
        $this->view->displayConnectionFailed();
      }
    }
    //utilisateur connecté -> le déconnecte
    else{
      $this->view->displayDeconnection();
      session_destroy();
    }
  }

}

?>
