<?php
class UtilisateurBuilder{

  /*data = array contenant les informations pour créé objet Ghilbi
  error = array qui contiendra les messages d'erreur lors de la création de l'object*/
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

  //fonctions créant un object Ghilbi en se basant sur le tableau mis dans le constructeur
  public function createUtilisateur(){
    $obj = new Utilisateur($this->data["nom"],$this->data["mdp"],$this->data["mail"],$this->data["tel"],$this->data["dateNais"],$this->data["filmFav"],"utilisateur");
    return $obj;
  }


  public function isValid(){

    //cette fonction verifiera que les champs de $this->data contiennent les bonnes infos
    $this->error= array();

    if(!key_exists('nom',$this->data) || $this->data['nom']===""){
      $this->error["nom"] = "Vous avez oubliez de renseigner un identifiant. \n <br>";
    }

    if(!key_exists('mdp',$this->data) || $this->data['mdp']==="" || strlen($this->data['mdp'])<10){
      $this->error["mdp"] = "Vous avez oubliez de renseigner un mot de passe ou votre mot de passe est trop court(10 caractères minimum). \n <br>";
    }

    $this->data['role'] = "utilisateur";
    if(!key_exists('role',$this->data) || $this->data['role']===""){
      $this->error["role"] = "Vous avez oubliez de renseigner un role. \n <br>";
    }

    if(!key_exists('mail',$this->data) || $this->data['mail']===""){
      $this->error["mail"] = "Vous avez oubliez de renseigner un mail. \n <br>";
    }

    if(!key_exists('tel',$this->data) || strlen($this->data['tel'])!==10 || !ctype_digit($this->data['tel'])){
      $this->error["tel"] = "Vous n'avez pas correctement saisis votre numéro de téléphone. \n <br>";
    }

    if(!key_exists('dateNais',$this->data) || $this->data['dateNais']===""){
      $this->error["dateNais"] = "Vous n'avez pas renseigné votre date de naissance. \n <br>";
    }

    if(!key_exists('filmFav',$this->data) || $this->data['filmFav']===""){
      $this->error["filmFav"] = "Vous n'avez pas dit quel était votre film préféré. \n <br>";
    }

    if(count($this->error) === 0){
      $this->data['mdp'] = password_hash($this->data['mdp'], PASSWORD_BCRYPT);
    }
    return (count($this->error) === 0);
  }
}

 ?>
