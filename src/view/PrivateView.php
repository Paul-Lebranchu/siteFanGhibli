<?php

require_once("Rooter.php");
require_once("model/GhilbiStorageMysql.php");
require_once("model/UtilisateurStorageMysql.php");

//classe gérant la vue pour les utilisateurs connectés
Class PrivateView extends View{

  private $compte;


  public function __construct($root,$feedback,Utilisateur $compte){
    $this->root = $root;
    $this->feedback = $feedback;
    $this->compte = $compte;
    $this->menu = $this->getMenu();
  }
  //Page d'acceuil utilisateur connecté
  public function makeAccueilPage(){
    $this->title  =  "Bienvenu(e) ".htmlspecialchars($_SESSION['pseudo']);
    $this->content = "
    <section>

      <p>Vous vous trouvez sur une page de fan du studio Ghibli, vous
      pourrez trouver de nombreux produits qui font références à vos films favoris, vous
      verrez aussi bien les films que les produits dérivés.</p>

    </section>


    <section>

      <p> Lorsque vous vous connectez au site, vous avez accès à plus de contenu. Vous pouvez
      accèder au détail des objets en cliquant dessus (dans la page liste ghibli), vous pourrez
      ajouter des objets à cette liste ou supprimer/modifier les objet que vous avez créé.  </p>

    </section>

    <section>

    <p>Voici votre identifiant : ".htmlspecialchars($_SESSION['id']).", cet identifiant vous permet de savoir quel objet vous avez créé.
    Cela vous sera utile pour savoir quel objet vous avez le droit de modifier/supprimer, cet identifiant sera
    ajouté lors de la création de votre objet et ne pourra être modifié </p>

    </section>";


    include "squelette.php";
  }

  //page de déconnexion
  public function makeLoginFormPage(){

    $this->title = 'Déconnexion';

    $this->content  = '<form  action="'.$this->root->getTentativeConnexionUrl().'" method="POST">'.
        '<button type="submit" name ="deconnexion">se déconnecter</button>'.'<br>'.
        '</form>';

    if(isset($_POST['deconnexion'])){
      session_destroy();
    }

    include "squelette.php";
  }

  public function ajoutObjetListe(GhilbiBuilder $objetGhibli){
    $nomProd="";
    $typeProd="";
    $image="";
    $date = date("Y-m-d");


    $this->error = $objetGhibli->__getError();

    $error ="";
    foreach($this->error as $key=>$value){
      $error .= $value."\n";
    }
    if(key_exists("nomProd",$objetGhibli->__getData()) && !key_exists("nomProd",$this->error)){
      $nomProd = $objetGhibli->__getData()['nomProd'];
    }
    if(key_exists("typeProd",$objetGhibli->__getData()) && !key_exists("typeProd",$this->error)){
      $typeProd = $objetGhibli->__getData()['typeProd'];
    }
    if(key_exists("image",$objetGhibli->__getData()) && !key_exists("image",$this->error)){
      $image = $objetGhibli->__getData()['image'];
    }
    if(key_exists("date",$objetGhibli->__getData()) && !key_exists("date",$this->error)){
      $date = $objetGhibli->__getData()['date'];
    }
    $id_crea = $_SESSION['id'];

    $this->title = "Ajout d'objet";

    $this->content = "

    <section>

      <p>Vous pouvez remplir le formulaire ci dessous pour créer un nouvel objet.</p>

    </section>
    <section>
    ".$error."

    <form action='".$this->root->getCreaObjetUrl()."' method='post'>
    <div>
      <label> Nom du produit :
      <br>
      <input type='text' name='nomProd' value='".$nomProd."' placeholder='Totoro' />
      </label>
    </div>
    <div>
      <label> Type du produit :
      <br>
      <input type='text' name='typeProd' value='".$typeProd."' placeholder='peluche, dvd...' />
      </label>
    </div>
    <div>
      <label> Lien de l'image :
      <br>
      <input type='url' name='image' value='".$image."' placeholder='http://image.jpeg' />
      </label>
    </div>
    <div>
      <label> Date de création de l'objet :
      <br>
      <input type='date' name='date' value='".$date."' />
      </label>
      <input type='hidden' name='id_crea' value='".$id_crea."'/>
      <input type='hidden' name='id_objet' value='-1'/>
    </div>
    <div  class='envoyer'>
      <input type='submit' value='créer un objet'/>
     </div>
    </form>

    </section>
    ";

    include "squelette.php";
  }

    public function ModifObjet(GhilbiBuilder $objetGhibli){
      $infoGhibli = $objetGhibli->__getData();
      $nomProd="";
      $typeProd="";
      $image="";
      $date=date("Y-m-d");

      $this->error = $objetGhibli->__getError();

      $error ="";
      foreach($this->error as $key=>$value){
        $error .= $value."\n";
      }
      if(key_exists("nomProd",$infoGhibli) && !key_exists("nomProd",$this->error)){
        $nomProd = $infoGhibli['nomProd'];
      }
      if(key_exists("typeProd",$infoGhibli) && !key_exists("typeProd",$this->error)){
        $typeProd = $infoGhibli['typeProd'];
      }
      if(key_exists("image",$infoGhibli) && !key_exists("image",$this->error)){
        $image = $infoGhibli['image'];
      }
      if(key_exists("date",$infoGhibli)){
        $date = $infoGhibli["date"];
      }
      $id_crea = $_SESSION['id'];

      $this->title = "Modification sur un objet";

      $this->content = "

      <section>

        <p>Vous pouvez remplir le formulaire ci dessous pour modifier votre objet.</p>

      </section>
      <section>
      ".$error."

      <form action='".$this->root->getUpdateObjetUrl()."' method='post'>
      <div>
        <label> Nom du produit :
        <br>
        <input type='text' name='nomProd' value='".$nomProd."' />
        </label>
      </div>
      <div>
        <label> Type du produit :
        <br>
        <input type='text' name='typeProd' value='".$typeProd."' />
        </label>
      </div>
      <div>
        <label> Lien de l'image :
        <br>
        <input type='url' name='image' value='".$image."'/>
        </label>
      </div>
      <div>
        <label> Date de création de l'objet :
        <br>
        <input type='date' name='date' value='".$date."'/>
        </label>
      </div>
      <div>
        <label> identifiant du créateur : ".$id_crea."</label>
        <input type='hidden' name='id_crea' value='".$id_crea."'/>
      </div>
      <div>
        <label> identifiant de l'objet : ".$infoGhibli["id_objet"]."
        <input type='hidden' name='id_objet' value='".$infoGhibli["id_objet"]."'/>
      </div>
      <div  class='envoyer'>
        <input type='submit' value='modifier cet objet'/>
       </div>
      </form>

      </section>
      ";

      include "squelette.php";
  }

  //liste pour utilisateur connecté
  public function makeListPage($objet){
		$this->title = "Objets Ghibli";


    foreach ($objet as $object){
      $this->liste .= "<li> <a href='".$this->root->getDetailObjetUrl($object->__getIdObjet())."'>".$object->__getNomProduit()."</a></li> \n";
    }
		$this->content = "
      <section>
        Voici la liste des objets répertoriés dans notre base de donnée, n'hésitez pas
        à cliquer sur le lien pour voir les détails le concernant!



        <form action='".$this->root->getRechercheUrl()."' method='post'>
        <div>
        <br>
        <label>Recherche d'objet:
        <input type='text' name='recherche' placeholder='par nom'/>
        </label>
        <label>
        <input type='text' name='num' placeholder='par numéro créateur'>
        </label>
      </div>
      <div  class='envoyer'>
        <input type='submit' value='rechercher cet objet'/>
       </div>
        </form>



        <ul>
        ".$this->liste."
      </ul>
      </section>
    ";
		include "squelette.php";
  }

  //menu
  public function getMenu(){
    $menu = "<nav>
              <a href='".$this->root->getAccueilUrl()."'>Accueil</a>
              <a href='".$this->root->getAjoutObjetUrl()."'>Ajout d'objet</a>
              <a href='".$this->root->getAproposUrl()."'>Page à propos</a>
              <a href='".$this->root->getListeURL()."'>Liste des objets Ghibli</a>
              <a href='".$this->root->getConnexionUrl()."'>Déconnexion</a>
            </nav>";

    return $menu;
  }

  public function makeDetailPage(Ghibli $objetGhibli, $objet){
    $descriptif = ['ce merveilleux', 'ce sublime', 'cet extraordinaire', "cet époustouflant", "cet incroyable", "cet étrange", "cet étonnant", "cet intriguant"];
    $this->title = "objet";
    $form = "";
    $owner = "";

    foreach ($objet as $object){
      if($object->__getIdObjet() != $objetGhibli->__getIdObjet()){
        $this->liste .= "<li> <a href='".$this->root->getDetailObjetUrl($object->__getIdObjet())."'>".$object->__getNomProduit()."</a></li> \n";
      }
    }

    if($objetGhibli->__getIdCreateur()===$_SESSION['id']){
      $choix = rand(0, count($descriptif)-1);
      $owner ="<section><p>Puisque vous avez créé ".$descriptif[$choix]." objet, vous avez la possibilité de le modifier en cliquant sur le bouton modifier ou de le supprimer en cliquant sur le bouton supprimer</p></section>";

      $form ="<section>
        <div id='modSupp'>
        <form action='".$this->root->getModifObjetUrl()."' method='post'>

        <input type='hidden' name='nomProd' value='".$objetGhibli->__getNomProduit()."'/>
        <input type='hidden' name='typeProd' value='".$objetGhibli->__getTypeProduit()."'/>
        <input type='hidden' name='image' value='".$objetGhibli->__getURLImage()."'/>
        <input type='hidden' name='date' value='".$objetGhibli->__getDateCreation()."'/>
        <input type='hidden' name='id_crea' value='".$objetGhibli->__getIdCreateur()."'/>
        <input type='hidden' name='id_objet' value='".$objetGhibli->__getIdObjet()."'/>

        <input type='submit' value='modifier cet objet'/>
      </form>
      <form action='".$this->root->getSupprimerURL()."' method='post'>
      <input type='hidden' name='id_objet' value='".$objetGhibli->__getIdObjet()."'/>
        <input type='submit' value='supprimer cet objet'/>
      </form>
      <div>
      </section>";
    }


    $this->content = "
    <section>
    <h1>" . htmlspecialchars($objetGhibli->__getNomProduit())." <h1>
    </section>
    ".$owner .$form."
    <div>
      <section class = ref>
       L'objet ".htmlspecialchars($objetGhibli->__getNomProduit())." a été ajouté le ".htmlspecialchars($objetGhibli->__getDateCreation())." par l'utilisateur n°".htmlspecialchars($objetGhibli->__getIdCreateur()).".
        <br><br>C'est un objet de type ".htmlspecialchars($objetGhibli->__getTypeProduit()).".
        <br><br>Il s'agit de l'objet n°<small> " . htmlspecialchars($objetGhibli->__getIdObjet()) . "</small>
      </section>
      <section class = image>
        <img src = ".htmlspecialchars($objetGhibli->__getURLImage())." alt = ".htmlspecialchars($objetGhibli->__getNomProduit())."/>
      </section>
      <section class = navigation>
        <p> Consulter d'autres produits :</p>
        <ul>
        ".$this->liste."
      </ul>
      </section>
    </div>

    ";
    include "squelette.php";
  }


  public function makeSupprimerPage($id){
		$this->title = "Supprimer l'objet";
		$this->content = "<section>Voulez vous supprimer l'objet? Si oui, appuyer sur le bouton";
		$this->content .= '<form action="'.$this->root->getSupprURL().'" method="POST">';
    $this->content.= "<input type='hidden' name='id_objet' value='".$id."'/>";
		$this->content .= "<div class='envoyer'><input type='submit' value='supprimer cet objet'/></div></form></section>";
		include "squelette.php";
	}

	public function makeDefSupprimerPage(){
		$this->title = "Suppression";
		$this->content = "Votre objet à bien été supprimé.";
		include "squelette.php";
	}

  //fonction assurant la redirection en cas de succès lors de la création de l'objet Ghibli
  public function displayObjectSuccess(){
    $this->root->POSTredirect($this->root->getAjoutObjetUrl(), "Tentative de création de l'objet réussie");
  }

  //fonction assurant la redirection en cas d'échec de création de l'objet
  public function displayObjectCreationFailed(){
    $this->root->POSTredirect($this->root->getAjoutObjetUrl(), "Tentative de création de l'objet échouée");
  }

  public function displayDeconnection(){
    $this->root->POSTredirect($this->root->getAccueilUrl(), "Vous êtes déconnecté(e)");
  }

  public function displayObjectModificationSuccess($numId){
    $this->root->POSTredirect($this->root->getDetailObjetUrl($numId), "Tentative de modification de l'objet réussie");
  }

  public function displayObjectModificationFailed(){
    $this->root->POSTredirect($this->root->getModifObjetUrl(), "Tentative de modification de l'objet échouée");
  }
  public function displayObjectSuppressionFailed(){
    $this->root->POSTredirect($this->root->getSupprimerURL(), "Tentative de suppression de l'objet échouée");
  }

  //page interdite
  public function makeCreationComptePage(UtilisateurBuilder $utilisateur){
    $this->makeErrorPage("Inutile de vous créer un compte","Vous êtes déjà connecté(e), vous n'avez pas besoin de vous recréer un compte!");
  }

  public function displayUserCreationFailed(){
    $this->makeErrorPage("Inutile de vous créer un compte","Vous êtes déjà connecté(e), vous n'avez pas besoin de vous recréer un compte!");
  }

  //page objet introuvable
  public function unknowObject(){
    $this->makeErrorPage("L'objet recherché n'existe pas","Vous cherchez un objet qui n'existe pas ou qui n'existe plus, nous vous invitons à consulter la liste des objets!");
  }
}
