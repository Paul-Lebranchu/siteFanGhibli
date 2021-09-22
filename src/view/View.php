<?php

require_once("Rooter.php");
require_once("model/GhilbiStorageMysql.php");
require_once("model/UtilisateurStorageMysql.php");
Class View{

  protected $root;

  //titre et contenu de la page
  protected $title;
  protected $content;

  //menu
  protected $menu;

  //variable affichant le résultats d'un formulaire : succés ou échec
  protected $feedback;
  protected $error;

  //variable utilisé pour les champs des différents formulaire:
  //formulaire de création de compte
  protected $nom;
  protected $mdp;
  protected $mail;
  protected $tel;
  protected $dateNais;
  protected $filmFav;

  //variable pour la liste
  protected $liste;

  public function __construct($root,$feedback){
    $this->root = $root;
    $this->feedback = $feedback;
    $this->menu = $this->getMenu();
  }

  //fonction créant les différentes pages

  public function makeAProposPage(){

    $this->title = "A propos";
    $this->content = "

    <section>

      <h2>Groupe numéro 2</h2>
      <ul>
        <li>Marguerite Bauchez 21803320</li>
        <li>OlivierCocquerez 21803239</li>
        <li>Paul Lebranchu 21403460</li>
        <li>Raphaelle Lemaire 21802756</li>
      </ul>
    </section>

    <section>

      <h2> Taches accomplies </h2>

      <ul>
        <li> MVCR en place </li>
        <li> CSS en place /responsive </li>
        <li> Page d'acceuil opérationnelle</li>
        <li> Page de liste d'objets</li>
        <li> Création de compte/connexion/déconnexion en place </li>
        <li> Ajout d'objets a la liste</li>
        <li> Liste pour utilisateur non connecté(e) en place <li>
        <li> Liste pour utilisateur connecté(e) en place </li>
        <li> Modification des objets </li>
        <li> Suppresion des objets </li>
        <li> Image dans la vue des objets</li>
        <li> Gestion des pages non autorisées</li>
        <li> Recherche d'objet</li>
      </ul>
    </section>

    <section>
      <h2> Répartition des taches </h2>
      <ul>
        <li>Marguerite : Création et ajout des objets dans la base de données, creation des liens vers la page des objets,modification d'objet, recherche d'objet par nom et/ou par n° de créateur </li>
        <li>Olivier : Affichage de l'objet, navigation rapide entre objets dans la page détail objet</li>
        <li>Paul : Architecture globale du site/des fichiers, création des bases de données, gestion de création de compte, connexion et déconnexion, gestion des pages non autorisées</li>
        <li>Raphaelle : CSS, adaptation du site au CSS, création de la liste d'objet, suppression d'objet</li>
      </ul>
    </section>

    <section>
      <h2> Choix  des patterns, du design et autres</h2>
      <ul>
        <li> Thématique du site: films et produits dérivés des studios Ghibli ( appréciant nous même les films ) </li>
        <li> CSS: nous avons trouvé une <a href='ghibligabble.blogspot.com'>image sur internet </a> et l'avons ainsi utilisé comme base des couleurs du site</li>
        <li> Lien de l'image des <a href='https://dribbble.com/shots/2453526-Dailyui-Day008'> pages d'erreur </a> </li>
      </ul>
    </section>

    <section>
      <h2> Commentaire </h2>

      <p>Nous avons utilisés deux tables dans notre base de données: le première table gère les utilisateurs et la seconde gère les produits
      Ghibli </p>
    </section>
     ";



    include "squelette.php";
  }

  public function makeAccueilPage(){
    $this->title  =  "Bienvenue utilisateur non connecté(e)";
    $this->content = "
    <section>

      <p>Vous vous trouvez sur une page de fan du studio Ghibli, vous
      pourrez trouver de nombreux produits qui font référence à vos films favoris, vous
      verrez aussi bien les films que les produits dérivés. Pour pouvoir faire plus d'action,
      créez-vous un compte ou connectez vous! </p>

    </section>

    <section>

      <p> Si vous n'êtes pas connecté(e) au site, vous ne pourrez accèder qu'a la page d'accueil
      /à propos/liste(sans le détail des objets)/création de compte/connexion </p>

    </section>


    <section>

      <p> Lorsque vous vous connectez au site, vous avez accès à plus de contenu. Vous pouvez
      accèder au détail des objets en cliquant dessus (dans la page liste ghibli), vous pourrez
      ajouter des objets à cette liste ou supprimer/modifier les objet que vous avez créé.</p>

    </section>";



    include "squelette.php";
  }

  public function makeCreationComptePage(UtilisateurBuilder $utilisateur){

    //paramètre gérant les erreur
    $this->error = $utilisateur->__getError();
    //si il y aune erreur quand on rempli le formulaire, on l'ajoute dans cette variable
    $error ="";
    foreach($this->error as $key=>$value){
      $error .= $value."\n";
    }

    //si la valeur est correctement rentrée, on la stocke
    if(key_exists("nom",$utilisateur->__getData()) && !key_exists("nom",$this->error)){
      $this->nom = $utilisateur->__getData()['nom'];
    }
    if(key_exists("mdp",$utilisateur->__getData()) && !key_exists("mdp",$this->error)){
      $this->mdp = $utilisateur->__getData()['mdp'];
    }
    if(key_exists("mail",$utilisateur->__getData()) && !key_exists("mail",$this->error)){
      $this->mail = $utilisateur->__getData()['mail'];
    }
    if(key_exists("tel",$utilisateur->__getData()) && !key_exists("tel",$this->error)){
      $this->tel = $utilisateur->__getData()['tel'];
    }
    if(key_exists("filmFav",$utilisateur->__getData()) && !key_exists("filmFav",$this->error)){
      $this->filmFav = $utilisateur->__getData()['filmFav'];
    }

    $this->title = "Création de compte";

    $this->content = "

    <section>

      <p>Vous avez décidé de nous rejoindre? Félicitation! Remplissez ce formulaire
      et vous pourrez accéder à de nouvelles fonctionnalités en temps que nouvel(le) utilisateur(trice)!
      </p>

    </section>

    <section>
    ".$error."

    <form action='".$this->root->getCompteSaveUrl()."' method='post'>
    <div>
      <label> Nom d'utilisateur :</label>
      <br>
      <input type='text' name='nom' value='".$this->nom."' placeholder='Totoro' />
    </div>
    <div>
      <label> Mot de passe :</label>
      <br>
      <input type='password' name='mdp' value='".$this->mdp."' placeholder='1234maisPlusCompliqué' />
    </div>
    <div>
      <label> Adresse Mail:</label>
      <br>
      <input type='email' name='mail' value='".$this->mail."' placeholder='chihiro@gmail.com' />
    </div>
    <div>
      <label> Téléphone:</label>
      <br>
      <input type='tel' name='tel' value='".$this->tel."' placeholder='0123456789' />
    </div>
    <div>
      <label> Date de naissance :</label>
      <br>
      <input type='date' name='dateNais' value='' />
    </div>
    <div>
      <label> Film Ghilbi préféré :</label>
      <br>
      <input type='text' name='filmFav' value='".$this->filmFav."' placeholder='Le royaume des chats' />
    </div>
    <div  class='envoyer'>
      <input type='submit' value='créé votre compte'/>
     </div>
    </form>

    </section>
    ";


    include "squelette.php";
  }

  public function makeListPage($objet){
		$this->title = "Objets Ghibli";


    foreach ($objet as $object){
      $this->liste .= "<li> ".$object->__getNomProduit()."</li> \n";
    }

		$this->content = "
      <section>
        Vous n'êtes pas connecté(e), vous pouvez voir la liste des différents objets présent dans notre base
        de donnée mais vous ne pourrez pas accéder à leurs détails (image correspondante/date de création ...).
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

  public function makeLoginFormPage(){
    $this->title = 'Connexion';

    $this->content  = '<section>
        <form  action="'.$this->root->getTentativeConnexionUrl().'" method="POST">'.
        '<label>Nom : <input type="text" name="login" /></label>'.'<br>'.
        '<label>Mot de passe : <input type="password" name="password"></label>'.'<br>'.
        '<button type="submit">se connecter</button>'.'<br>'.
        '</form>
        </section>';
    include "squelette.php";
  }

  public function getMenu(){
    $menu = "<nav>
              <a href='".$this->root->getAccueilUrl()."'>Accueil</a>
              <a href='".$this->root->getCreaCompteUrl()."'>Création de compte</a>
              <a href='".$this->root->getAproposUrl()."'>Page à propos</a>
              <a href='".$this->root->getListeURL()."'>Liste des objets Ghibli</a>
              <a href='".$this->root->getConnexionUrl()."'>Connexion</a>
            </nav>";

    return $menu;
  }


  //fonction assurant la redirection en cas de création de compte avec succès
  public function displayUtilisateurSuccess(){
    $this->root->POSTredirect($this->root->getAccueilUrl(), "Tentative de création de compte réussie");
  }

  //fonction assurant la redirection en cas d'échec de création de compte
  public function displayUserCreationFailed(){
    $this->root->POSTredirect($this->root->getCreaCompteUrl(), "Tentative de création de compte ratée");
  }

  public function displayConnectionSuccess(){
    $this->root->POSTredirect($this->root->getAccueilUrl(), "Connection réussie");
  }

  public function displayConnectionFailed(){
    $this->root->POSTredirect($this->root->getConnexionUrl(), "Connection ratée");
  }

  //page interdite au simple visiteur
  public function makeErrorPage($titre,$messageError){

    $this->title = $titre;

    $this->content = " <section class = error>

    ".$messageError."
    <br><br><br>
    <img src = 'Style/image/404.png' alt='error404 mononoke'>
    <br>
    (source image :https://dribbble.com/shots/2453526-Dailyui-Day008)

    </section>";

    include "squelette.php";

  }
  public function ajoutObjetListe(GhilbiBuilder $objetGhibli){
    $this->makeErrorPage("Vous n'avez pas les droits pour créer des objets","Vous devez être connecté(e) pour créer un object!");
  }

  public function makeDetailPage(Ghibli $objetGhibli, $objet){
    $this->makeErrorPage("Vous n'avez pas les droits pour voir des objets","Vous devez être connecté(e) pour voir un object!");
  }

  public function ModifObjet(GhilbiBuilder $objetGhibli){
    $this->makeErrorPage("Vous n'avez pas les droits pour modifier des objets","Vous devez être connecté(e)  et avoir créé l'objet pour pouvoir le modifier!");
  }

  public function makeSupprimerPage($id){
    $this->makeErrorPage("Vous n'avez pas les droits pour supprimer des objets","Vous devez être connecté(e)  et avoir créé l'objet pour pouvoir le supprimer!");
  }

  public function makeDefSupprimerPage(){
    $this->makeErrorPage("Vous n'avez pas les droits pour supprimer des objets","Vous devez être connecté(e)  et avoir créé l'objet pour pouvoir le supprimer!");
  }

  public function displayObjectCreationFailed(){
    $this->makeErrorPage("Vous n'avez pas les droits pour créer des objets","Vous devez être connecté(e) pour créer un object!");
  }

  public function displayObjectModificationFailed(){
    $this->makeErrorPage("Vous n'avez pas les droits pour modifier des objets","Vous devez être connecté(e)  et avoir créé l'objet pour pouvoir le modifier!");
  }

  public function displayObjectSuppressionFailed(){
    $this->makeErrorPage("Vous n'avez pas les droits pour supprimer des objets","Vous devez être connecté(e)  et avoir créé l'objet pour pouvoir le supprimer!");
  }

  public function unknowObject(){
    $this->makeErrorPage("Vous n'avez pas les droits pour voir des objets","Vous devez être connecté(e) pour voir un object!");
  }

}
?>
