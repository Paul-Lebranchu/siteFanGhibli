<?php
require_once("model/Ghibli.php");

class GhilbiBuilder{

  /*data = array contenant les informations pour créer objet Ghibli
  error = array qui contiendra les messages d'erreur lors de la création de l'objet*/
  private $data;
  private $error;

  public function __construct(array $data){
    $this->data = $data;
    $this->error = array();
  }

  public function __getData(){
    return $this->data;
  }

  public function __getError(){
    return $this->error;
  }

  //fonctions créant un objet Ghibli en se basant sur le tableau mit dans le constructeur
  public function createGhibli(){
    if(key_exists('id_crea',$this->data)){
      $obj = new Ghibli($this->data["nomProd"],$this->data["typeProd"],$this->data["image"],$this->data["date"],$this->data["id_crea"],(int)$this->data["id_objet"]);
    }elseif(key_exists('id',$_SESSION)){
      $obj = new Ghibli($this->data["nomProd"],$this->data["typeProd"],$this->data["image"],$this->data["date"],$_SESSION['id'],(int)$this->data["id_objet"]);
    }else{
      $obj = new Ghibli($this->data["nomProd"],$this->data["typeProd"],$this->data["image"],$this->data["date"],(int)-1,(int)$this->data["id_objet"]);
    }
    return $obj;
  }


  public function isValid(){
    //cette fonction verifie que les champs de $this->data contiennent les bonnes infos
    $this->error= array();

    if(!key_exists('nomProd',$this->data) || $this->data['nomProd']===""){
      $this->error["nomProd"] = "Vous avez oublié de renseigner le nom de l'objet. \n <br>";
    }

    if(!key_exists('typeProd',$this->data) || $this->data['typeProd']===""){
      $this->error["typeProd"] = "Vous avez oublié de renseigner le type du produit. \n <br>";
    }

    if(!key_exists('image',$this->data) || $this->data['image']===""){
      $this->error["image"] = "Vous avez oublié de renseigner le lien de l'image. \n <br>";
    }

    if(!key_exists('date',$this->data) || $this->data['date']===""){
      $this->error["date"] = "Vous avez oublié de renseigner la date de création de l'objet. \n <br>";
    }
    if(!key_exists('id_crea',$this->data) || is_null($this->data['id_crea'])){
      $this->error["id_crea"] = "Le formulaire ne renvoi pas d'ID utilisateur. \n <br>";
    }
    return (count($this->error) === 0);
  }
}

 ?>
