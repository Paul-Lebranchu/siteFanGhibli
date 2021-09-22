<?php
//classe qui gère les objets que nous présenterons sur le site
Class Ghibli{

  protected $nomProduit;
  protected $typeProduit;
  protected $URLImage;
  protected $dateCreation;
  protected $id_createur;
  protected $id_objet;

  public function __construct(String $nomProduit,String $typeProduit,String $URLImage=null,String $dateCreation, int $id_crea,int $id_objet){
    $this->nomProduit = $nomProduit;
    $this->typeProduit = $typeProduit;
    $this->URLImage = $URLImage;
    $this->dateCreation = $dateCreation;
    $this->id_createur = $id_crea;
    $this->id_objet = $id_objet;
  }

  public function __getNomProduit(){
    return $this->nomProduit;
  }

  public function __getTypeProduit(){
    return $this->typeProduit;
  }

  public function __getURLImage(){
    return $this->URLImage;
  }

  public function __getDateCreation(){
    return $this->dateCreation;
  }

  public function __getIdCreateur(){
    return $this->id_createur;
  }

   public function __getIdObjet(){
    return $this->id_objet;
  }
}
 ?>
