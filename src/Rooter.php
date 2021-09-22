<?php
require_once("view/View.php");
require_once("view/PrivateView.php");
require_once("controller/Controller.php");
require_once("model/GhilbiStorageMysql.php");
require_once("model/UtilisateurStorageMysql.php");
require_once("model/UtilisateurBuilder.php");

class Rooter{

  public $ghilbi_bd;/*, controle public list page*/
  public $utilisateur_bd;


  //fonctions chargé de récupéré les différentes url des pages
  public function getAproposUrl(){
    $url = "?aPropos";
    return $url;
  }

  public function getAccueilUrl(){
    $url = "?accueil";
    return $url;
  }

  public function getListeURL(){
	$url = "?liste";
    return $url;
  }

  public function getCreaCompteUrl(){
    $url = "?action=newCompte";
    return $url;
  }
  public function getCompteSaveUrl(){
    $url = "?action=sauverCompte";
    return $url;
  }

  public function getConnexionUrl(){
    $url = "?action=connect";
    return $url;
  }

  public function getTentativeConnexionUrl(){
    $url = "?action=connexion";
    return $url;
  }

  public function getCreaObjetUrl(){
    $url = "?action=saveObject";
    return $url;
  }

  public function getAjoutObjetUrl(){
  	$url = "?action=ajoutObjet";
  	return $url;
  }

  public function getModifObjetUrl(){
    $url = "?action=modifObjet";
    return $url;
  }

  public function getUpdateObjetUrl(){
    $url = "?action=updateObjet";
    return $url;
  }

  public function getDetailObjetUrl($numId){
    $url = "?id=".$numId;
    return $url;
  }

  	public function getSupprimerURL(){
		return "?action=supprimer";
	}
	public function getSupprURL() {
		return "?action=definitiveSuppression";
	}

  public function getRechercheUrl(){
    return "?action=recherche";
  }


  public function __construct(GhilbiStorageMysql $ghilbi_bd, UtilisateurStorageMysql $utilisateur_bd){
    $this->ghilbi_bd =$ghilbi_bd;
    $this->utilisateur_bd = $utilisateur_bd;
  }

  //fonction lancé sur index.php
  public function main(){

    //création d'une session pour gérer les feedback des formulaire et les connections
    session_start();

    //remise à zéro du feedback après son affichage -> le feedback s'affichera qu'une seule fois
    if(!key_exists('feedback',$_SESSION)){
      $_SESSION['feedback'] = "";
    }

    //création d'une vue, la vue sera différente si l'utilisateur est conectée ou non
    if(!key_exists('user',$_SESSION)){
      $view = new View($this,$_SESSION['feedback']);
    }else{
      $view = new PrivateView($this,$_SESSION['feedback'],$_SESSION['user']);
    }

    unset($_SESSION['feedback'] );

    //création d'un controlleur
    $ctr = new Controller($view, $this->ghilbi_bd, $this->utilisateur_bd);

    //routage
    $action = key_exists('action', $_GET)? $_GET['action']: null;


    if(!key_exists("action",$_GET)){

      if(key_exists("aPropos",$_GET)){
        $ctr-> aProposPage();
      }
      elseif(key_exists("liste",$_GET)){
			     $ctr->showList();
      }
      elseif(key_exists("id",$_GET)){
        $ctr->detailObjet($_GET['id']);
		  }else{
			     $ctr-> accueilPage();
      }
    }
    else{
      try{
        switch($action){
          //action par rapport à la création de compte
          case "newCompte":
            $view->makeCreationComptePage($ctr->newCompte());
            break;
          case "sauverCompte":
            $ctr->sauvegardeCompte($_POST);
            break;
          //action de connexion
          case "connect":
            $ctr->connexionPage();
            break;
          case "connexion":
            $ctr->connect($this->utilisateur_bd->readAll(),$_POST);
            break;
          //création d'objet
          case "saveObject":
            $ctr->sauvegardeObjet($_POST);
            break;
          case "ajoutObjet":
          	$ctr->creationObject();
            break;
          //modification d'objet
          case "modifObjet":
            $ctr->modifObjet($_POST);
            break;
          case "updateObjet":
            $ctr->updateObjet($_POST);
            break;
          //suppresion d'objet
          case "supprimer":
				    $ctr->supprimer($_POST["id_objet"]);
				    break;
			    case "definitiveSuppression":
    				$ctr->defSupprimer($_POST["id_objet"]);
    				break;
          case "recherche":
            $ctr->recherche();
            break;
          default :
            $ctr-> accueilPage();
            break;
        }
      }catch (Exception $e) {
        $ctr->acceuilPage();
      }
    }
  }

  //fonction permettant la redirection vers autre page: sert principalemnent pour les formulaires
  public function POSTredirect($url, $feedback){
    $_SESSION['feedback'] = "<section>".$feedback."</section>";
    header("Location: " . $url, true, 303);

  }
}

 ?>
