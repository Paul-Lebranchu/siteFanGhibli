<?php
//classe qui gère les objets que nous présenterons sur le site
Class Utilisateur{

  protected $nom;
  protected $motDePasse;
  protected $role;//pour l'instant inutile mais peut être utile si on fait complément avec administrateur
  protected $mail;
  protected $tel;
  protected $dateNaissance;
  protected $filmFav;

  public function __construct(String $nom,String $motDePasse,String $mail, String $tel,String $dateNaissance,String $filmFav,String $role = "utilisateur"){
    $this->nom = $nom;
    $this->motDePasse = $motDePasse;
    $this->role = $role;
    $this->mail = $mail;
    $this->tel = $tel;
    $this->dateNaissance = $dateNaissance;
    $this->filmFav = $filmFav;
  }

  public function __getNom(){
    return $this->nom;
  }

  public function __getMDP(){
    return $this->motDePasse;
  }

  public function __getRole(){
    return $this->role;
  }

  public function __getMail(){
    return $this->mail;
  }

  public function __getTel(){
    return $this->tel;
  }

  public function __getDateNaissance(){
    return $this->dateNaissance;
  }

  public function __getFilmFav(){
    return $this->filmFav;
  }
}
 ?>
